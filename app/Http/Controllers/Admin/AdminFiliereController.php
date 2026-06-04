<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Serie;
use App\Models\Campus;
use App\Models\Interet;
use App\Models\Debouche;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminFiliereController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_id')) return redirect()->route('admin.login');
        return null;
    }

    public function index(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        $query = Filiere::with(['campus.universite', 'responsableSoumis']);
        if ($request->statut) {
            $query->where('statut', $request->statut);
        }
        $filieres = $query->latest()->paginate(15);
        return view('admin.filieres.index', compact('filieres'));
    }

    public function create()
    {
        if ($r = $this->checkAuth()) return $r;

        $series  = Serie::orderBy('code')->get();
        $campus  = Campus::with('universite')->orderBy('nom')->get();
        $interets = Interet::orderBy('libelle')->get();

        return view('admin.filieres.create', compact('series', 'campus', 'interets'));
    }

    public function store(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        // Validation manuelle
        $nom = trim($request->input('nom', ''));
        $description = trim($request->input('description', ''));
        $duree_annees = $request->input('duree_annees');
        $mode_entree = trim($request->input('mode_entree', ''));
        $quota_bourse = $request->input('quota_bourse');
        $quota_aide_fpp = $request->input('quota_aide_fpp');
        $seuil_bourse = $request->input('seuil_bourse');
        $campus = $request->input('campus');
        $series = $request->input('series');

        $errors = [];
        if (empty($nom) || strlen($nom) > 200) {
            $errors['nom'] = 'Le nom est requis (max 200 caractères).';
        }
        if (empty($description)) {
            $errors['description'] = 'La description est requise.';
        }
        if (empty($duree_annees) || !is_numeric($duree_annees) || $duree_annees < 1) {
            $errors['duree_annees'] = 'La durée doit être un nombre égal ou supérieur à 1.';
        }
        if (empty($mode_entree) || !in_array($mode_entree, ['classement', 'concours', 'dossier', 'direct'])) {
            $errors['mode_entree'] = 'Le mode d\'entrée est invalide.';
        }
        if (!is_numeric($quota_bourse) || $quota_bourse < 0) {
            $errors['quota_bourse'] = 'Le quota bourse doit être égal ou supérieur à 0.';
        }
        if (!is_numeric($quota_aide_fpp) || $quota_aide_fpp < 0) {
            $errors['quota_aide_fpp'] = 'Le quota aide FPP doit être égal ou supérieur à 0.';
        }
        if (!is_numeric($seuil_bourse) || $seuil_bourse < 0 || $seuil_bourse > 20) {
            $errors['seuil_bourse'] = 'Le seuil bourse doit être entre 0 et 20.';
        }
        if (empty($campus) || !is_array($campus) || count($campus) < 1) {
            $errors['campus'] = 'Au moins un campus est requis.';
        }
        if (empty($series) || !is_array($series) || count($series) < 1) {
            $errors['series'] = 'Au moins une série est requise.';
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        // Créer la filière directement validée par l'admin
        $filiere = Filiere::create([
            'nom'            => $nom,
            'description'    => $description,
            'duree_annees'   => (int)$duree_annees,
            'mode_entree'    => $mode_entree,
            'quota_bourse'   => (int)$quota_bourse,
            'quota_aide_fpp' => (int)$quota_aide_fpp,
            'statut'         => 'validee',
        ]);

        // Lier aux campus
        foreach ($campus as $id_campus) {
            DB::table('uni_filieres')->insert([
                'id_campus'    => $id_campus,
                'id_filiere'   => $filiere->id_filiere,
                'id_annee'     => 1,
                'quota_bourse' => (int)$quota_bourse,
                'seuil_bourse' => (float)$seuil_bourse,
            ]);
        }

        // Lier aux séries
        foreach ($series as $id_serie) {
            DB::table('filiere_serie_matieres')->insert([
                'id_filiere' => $filiere->id_filiere,
                'id_serie'   => $id_serie,
                'id_matiere' => 1,
                'coefficient'=> 1,
            ]);
        }

        // Lier aux intérêts
        if ($request->interets) {
            foreach ($request->interets as $id_interet) {
                DB::table('filiere_interet')->insert([
                    'id_filiere' => $filiere->id_filiere,
                    'id_interet' => $id_interet,
                ]);
            }
        }

        // Créer les débouchés
        if ($request->debouches) {
            foreach (explode(',', $request->debouches) as $d) {
                $d = trim($d);
                if ($d) {
                    $debouche = Debouche::firstOrCreate(['intitule' => $d], ['secteur' => 'Autre']);
                    DB::table('filiere_debouche')->insert([
                        'id_filiere'  => $filiere->id_filiere,
                        'id_debouche' => $debouche->id_debouche,
                    ]);
                }
            }
        }

        return redirect()->route('admin.filieres')
                         ->with('success', 'Filière ajoutée et validée avec succès !');
    }

    public function edit($id)
    {
        if ($r = $this->checkAuth()) return $r;
        $filiere = Filiere::findOrFail($id);
        return view('admin.filieres.edit', compact('filiere'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->checkAuth()) return $r;

        // Validation manuelle
        $nom = trim($request->input('nom', ''));
        $description = trim($request->input('description', ''));
        $statut = trim($request->input('statut', ''));

        $errors = [];
        if (empty($nom) || strlen($nom) > 200) {
            $errors['nom'] = 'Le nom est requis (max 200 caractères).';
        }
        if (empty($description)) {
            $errors['description'] = 'La description est requise.';
        }
        if (empty($statut) || !in_array($statut, ['en_attente', 'validee', 'rejetee'])) {
            $errors['statut'] = 'Le statut est invalide.';
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        $filiere = Filiere::findOrFail($id);
        $filiere->update([
            'nom' => $nom,
            'description' => $description,
            'statut' => $statut,
        ]);

        return redirect()->route('admin.filieres')
                         ->with('success', 'Filière mise à jour !');
    }

    public function valider($id)
    {
        if ($r = $this->checkAuth()) return $r;
        $filiere = Filiere::findOrFail($id);
        $filiere->update(['statut' => 'validee', 'motif_rejet' => null]);

        return back()->with('success', '✅ Filière validée avec succès !');
    }

    public function rejeter(Request $request, $id)
    {
        if ($r = $this->checkAuth()) return $r;

        // Validation manuelle
        $motif = trim($request->input('motif', ''));
        if (empty($motif) || strlen($motif) < 5) {
            return back()->withErrors(['motif' => 'Le motif doit contenir au moins 5 caractères.'])->withInput();
        }

        $filiere = Filiere::findOrFail($id);
        $filiere->update([
            'statut'      => 'rejetee',
            'motif_rejet' => $motif,
        ]);

        return back()->with('success', '❌ Filière rejetée. Le responsable en a été informé.');
    }

    public function destroy($id)
    {
        if ($r = $this->checkAuth()) return $r;
        Filiere::findOrFail($id)->delete();
        return back()->with('success', 'Filière supprimée.');
    }
}