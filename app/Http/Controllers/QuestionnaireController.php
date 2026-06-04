<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Filiere;
use App\Models\User;
use App\Models\Recommandation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $series   = Serie::with('matieres')->orderBy('code')->get();
        $filieres = Filiere::orderBy('nom')->get();

        $matieresSerie = [];
        foreach ($series as $serie) {
            $matieresSerie[$serie->code] = $serie->matieres->map(function ($matiere) {
                return [
                    'nom'  => $matiere->nom,
                    'coef' => $matiere->pivot->coefficient,
                ];
            })->toArray();
        }

        $matieresFiliere = [];
        $allMatieres = DB::table('filiere_serie_matieres')
            ->join('matieres', 'filiere_serie_matieres.id_matiere', '=', 'matieres.id_matieres')
            ->select(
                'filiere_serie_matieres.id_filiere',
                'matieres.nom',
                'filiere_serie_matieres.coefficient'
            )
            ->orderBy('filiere_serie_matieres.id_filiere')
            ->orderByDesc('filiere_serie_matieres.coefficient')
            ->get()
            ->groupBy('id_filiere');

        foreach ($filieres as $filiere) {
            $matieresFiliere[$filiere->id_filiere] = isset($allMatieres[$filiere->id_filiere])
                ? $allMatieres[$filiere->id_filiere]->take(3)->toArray()
                : [];
        }

        return view('questionnaire', compact('series', 'filieres', 'matieresSerie', 'matieresFiliere'));
    }

    public function submit(Request $request)
    {
        // 1. VALIDATION
        $request->validate([
            'serie'    => 'required',
            'mention'  => 'required',
            'moyenne'  => 'required|numeric|min:0|max:20',
            'score'    => 'required|numeric|min:0|max:20',
            'filiere'  => 'required',
            'notes'    => 'required',
        ]);

        $notesDecoded = json_decode($request->notes, true);
        if (!is_array($notesDecoded)) {
            return back()->withErrors(['notes' => 'Format de notes invalide.'])->withInput();
        }

        // 2. DÉTERMINER LE DIAGNOSTIC
        $scoreFloat  = (float) $request->score;
        $seuilBourse = 12.00; 
        
        $uniFiliere = DB::table('uni_filieres')->where('id_filiere', $request->filiere)->first();
        if ($uniFiliere) {
            $seuilBourse = floatval($uniFiliere->seuil_bourse ?? 12.00);
        }
        $seuilFpp = $seuilBourse - 1.5;

        if ($scoreFloat >= $seuilBourse) {
            $diagnostic = 'boursier';
        } elseif ($scoreFloat >= $seuilFpp) {
            $diagnostic = 'fpp';
        } else {
            $diagnostic = 'non_admissible';
        }

        $questionnaireData = [
            'serie'    => $request->serie,
            'mention'  => $request->mention,
            'moyenne'  => (float) $request->moyenne,
            'score'    => $scoreFloat,
            'filiere'  => $request->filiere,
            'notes'    => $notesDecoded,
            'ambition' => $request->input('ambition'),
        ];

        session(['questionnaire' => $questionnaireData]);

        // 3. SAUVEGARDE (UNIQUEMENT SI CONNECTÉ)
        // Correction : On utilise Auth::user() qui est plus fiable que session('user_id')
        $user = Auth::user();

        if ($user) {
            // Mise à jour du profil utilisateur
            $user->questionnaire_data = $questionnaireData;
            $user->save();

            $serieModel = Serie::where('code', $request->serie)->first();

            // Création de la recommandation
            // Correction : Utilisation de $user->id_user au lieu de $user->id
            $recommandation = Recommandation::create([
                'score'      => $scoreFloat,
                'diagnostic' => $diagnostic,
                'id_user'    => $user->id_user, 
                'id_filiere' => (int) $request->filiere,
                'id_serie'   => $serieModel?->id_serie,
            ]);

            // Sauvegarder les notes
            foreach ($notesDecoded as $noteItem) {
                if (!is_array($noteItem)) continue;

                $matiereModel = DB::table('matieres')
                    ->where('nom', $noteItem['matiere'])
                    ->first();

                if ($matiereModel) {
                    DB::table('recommandation_matieres')->insert([
                        'id_recommandation' => $recommandation->id_recommandation,
                        'id_matiere'        => $matiereModel->id_matieres,
                        'note'              => floatval($noteItem['note']),
                        'coefficient'       => floatval($noteItem['coef']),
                    ]);
                }
            }
        }

        return redirect()->route('resultats');
    }
}