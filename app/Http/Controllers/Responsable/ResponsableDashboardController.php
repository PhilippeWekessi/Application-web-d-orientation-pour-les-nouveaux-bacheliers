<?php
namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Campus;
use App\Models\Serie;
use App\Models\Matiere;
use App\Models\Debouche;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResponsableDashboardController extends Controller
{
    // Middleware vérification connexion
    private function checkAuth()
    {
        if (!session('responsable_id')) {
            return redirect()->route('responsable.login');
        }
        return null;
    }

    public function dashboard()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $idUniversite = session('responsable_uni');
        $filieres = Filiere::whereHas('campus', function($q) use ($idUniversite) {
            $q->where('id_universite', $idUniversite);
        })->with('campus')->get();

        $totalFilieres    = $filieres->count();
        $filiersValidees  = $filieres->where('statut', 'validee')->count();
        $filiersEnAttente = $filieres->where('statut', 'en_attente')->count();
        $filiersRejetees  = $filieres->where('statut', 'rejetee')->count();

        return view('responsable.dashboard', compact(
            'filieres', 'totalFilieres',
            'filiersValidees', 'filiersEnAttente', 'filiersRejetees'
        ));
    }

    public function createFiliere()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $series   = Serie::orderBy('code')->get();
        $matieres = Matiere::orderBy('nom')->get();

        return view('responsable.filiere-create', compact('series', 'matieres'));
    }

    public function storeFiliere(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $request->validate([
            'nom'          => 'required|string|max:200',
            'description'  => 'required|string',
            'duree_annees' => 'required|integer|min:1|max:10',
            'mode_entree'  => 'required|in:classement,concours,dossier,direct',
            'quota_bourse' => 'required|integer|min:0',
            'quota_fpp'    => 'required|integer|min:0',
            'seuil_bourse' => 'required|numeric|min:0|max:20',
            'series'       => 'required|array|min:1',
            'debouches'    => 'required|string',
        ]);

        $idUniversite = session('responsable_uni');

        // Créer ou récupérer le campus de l'université
        $campus = Campus::firstOrCreate(
            ['id_universite' => $idUniversite],
            ['nom' => 'Campus Principal', 'adresse' => 'N/A', 'ville' => 'N/A']
        );

        // Créer la filière avec statut en_attente
        $filiere = Filiere::create([
            'nom'                  => $request->nom,
            'description'          => $request->description,
            'duree_annees'         => $request->duree_annees,
            'mode_entree'          => $request->mode_entree,
            'quota_bourse'         => $request->quota_bourse,
            'quota_aide_fpp'       => $request->quota_fpp,
            'statut'               => 'en_attente',
            'id_universite_soumis' => $idUniversite,
        ]);

        // Lier campus et filière
        \DB::table('uni_filieres')->insert([
            'id_campus'    => $campus->id_campus,
            'id_filiere'   => $filiere->id_filiere,
            'id_annee'     => 1,
            'quota_bourse' => $request->quota_bourse,
            'seuil_bourse' => $request->seuil_bourse,
        ]);

        // Lier les séries
        foreach ($request->series as $id_serie) {
            // Lier les matières avec coefficients si fournis
            if ($request->has('matieres_' . $id_serie)) {
                foreach ($request->input('matieres_' . $id_serie) as $id_matiere => $coef) {
                    if ($coef > 0) {
                        \DB::table('filiere_serie_matieres')->insert([
                            'id_filiere' => $filiere->id_filiere,
                            'id_serie'   => $id_serie,
                            'id_matiere' => $id_matiere,
                            'coefficient'=> $coef,
                        ]);
                    }
                }
            }
        }

        // Créer les débouchés
        $debouchesList = explode(',', $request->debouches);
        foreach ($debouchesList as $d) {
            $d = trim($d);
            if ($d) {
                $debouche = Debouche::firstOrCreate(['intitule' => $d], ['secteur' => 'Autre']);
                \DB::table('filiere_debouche')->insert([
                    'id_filiere'  => $filiere->id_filiere,
                    'id_debouche' => $debouche->id_debouche,
                ]);
            }
        }

        return redirect()->route('responsable.dashboard')
                         ->with('success', 'Filière soumise avec succès ! Elle sera visible après validation par l\'administrateur.');
    }
}