<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Serie;
use App\Models\UniFiliere;
use Illuminate\Http\Request;

class ResultatController extends Controller
{
    public function index()
    {
        $questionnaire = session('questionnaire');

        if (!$questionnaire && session('user_id')) {
            $user = \App\Models\User::find(session('user_id'));
            if ($user && $user->questionnaire_data) {
                $questionnaire = is_string($user->questionnaire_data)
                    ? json_decode($user->questionnaire_data, true)
                    : $user->questionnaire_data;
                session(['questionnaire' => $questionnaire]);
            }
        }

        if (!$questionnaire) {
            return redirect()->route('questionnaire')
                             ->with('error', 'Veuillez d\'abord remplir le questionnaire.');
        }

        $serieCode = $questionnaire['serie'];
        $notes     = $questionnaire['notes'] ?? [];
        $filiereId = $questionnaire['filiere'] ?? null;

        $serie = Serie::where('code', $serieCode)->first();

        // ===== RÉCUPÉRER LES MATIÈRES DE LA FILIÈRE CHOISIE =====
        $matieresFiliere = [];
        if ($filiereId) {
            $matieresFiliere = \DB::table('filiere_serie_matieres')
                ->join('matieres', 'filiere_serie_matieres.id_matiere', '=', 'matieres.id_matieres')
                ->where('filiere_serie_matieres.id_filiere', $filiereId)
                ->select('matieres.nom', 'filiere_serie_matieres.coefficient')
                ->distinct()
                ->take(3)
                ->get()
                ->toArray();
        }

        // ===== CALCUL DE LA MOYENNE DE CLASSEMENT =====
        // Priorité 1 : utiliser le score déjà calculé côté JavaScript (le plus fiable)
        $moyenneClassement = floatval($questionnaire['score'] ?? 0);

        // Priorité 2 : si le score est 0 ou absent, recalculer depuis les notes et coefficients
        if ($moyenneClassement <= 0 && !empty($notes) && !empty($matieresFiliere)) {
            $coefs     = array_column($matieresFiliere, 'coefficient');
            $totalCoef = array_sum($coefs);
            $somme     = 0;

            foreach ($notes as $i => $note) {
                // Les notes peuvent être un tableau [{matiere, note, coef}] ou [valeur1, valeur2...]
                if (is_array($note)) {
                    $noteVal = floatval($note['note'] ?? 0);
                    $coef    = floatval($note['coef'] ?? ($coefs[$i] ?? 1));
                } else {
                    $noteVal = floatval($note);
                    $coef    = $coefs[$i] ?? 1;
                }
                $somme += $noteVal * $coef;
            }

            $moyenneClassement = $totalCoef > 0 ? round($somme / $totalCoef, 2) : 0;
        }

        // Mettre à jour le score dans la session
        $questionnaire['score'] = $moyenneClassement;
        session(['questionnaire' => $questionnaire]);

        // ===== RÉCUPÉRER LES FILIÈRES COMPATIBLES AVEC LA SÉRIE =====
        $filieres = Filiere::with(['campus.universite', 'series', 'interets'])
            ->whereHas('series', function($q) use ($serieCode) {
                $q->where('code', $serieCode);
            })
            ->get();

        // Si aucune filière pour cette série, prendre toutes
        if ($filieres->isEmpty()) {
            $filieres = Filiere::with(['campus.universite', 'series', 'interets'])->get();
        }

        // ===== CHARGER TOUS LES UNI_FILIERES EN UNE SEULE REQUÊTE =====
        $filiereIds  = $filieres->pluck('id_filiere')->toArray();
        $uniFilieres = UniFiliere::whereIn('id_filiere', $filiereIds)
                        ->get()
                        ->keyBy('id_filiere');

        // ===== CONSTRUIRE LES RÉSULTATS =====
        $resultats = [];

        foreach ($filieres as $filiere) {
            $uniFiliere  = $uniFilieres->get($filiere->id_filiere);
            $seuilBourse = floatval($uniFiliere?->seuil_bourse ?? 12.00);
            $seuilFpp    = $seuilBourse - 1.5;

            if ($moyenneClassement >= $seuilBourse) {
                $diagnostic = 'boursier';
            } elseif ($moyenneClassement >= $seuilFpp) {
                $diagnostic = 'fpp';
            } else {
                $diagnostic = 'non_admissible';
            }

            $resultats[] = [
                'filiere'      => $filiere,
                'moyenne'      => $moyenneClassement,
                'diagnostic'   => $diagnostic,
                'seuil_bourse' => $seuilBourse,
                'seuil_fpp'    => $seuilFpp,
                'is_selected'  => $filiere->id_filiere == $filiereId,
                'quota_bourse' => $uniFiliere?->quota_bourse ?? $filiere->quota_bourse,
                'quota_fpp'    => $filiere->quota_aide_fpp,
            ];
        }

        // ===== TRI =====
        usort($resultats, function($a, $b) {
            $ordre = ['boursier' => 0, 'fpp' => 1, 'non_admissible' => 2];

            // Filière sélectionnée en premier
            if ($a['is_selected'] !== $b['is_selected']) {
                return $b['is_selected'] - $a['is_selected'];
            }
            // Puis par diagnostic
            if ($ordre[$a['diagnostic']] !== $ordre[$b['diagnostic']]) {
                return $ordre[$a['diagnostic']] - $ordre[$b['diagnostic']];
            }
            // Puis par quota bourse décroissant
            return $b['quota_bourse'] - $a['quota_bourse'];
        });

        return view('resultats', compact('resultats', 'questionnaire'));
    }
}