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

        $query = Filiere::with('campus.universite');
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

        $request->validate([
            'nom'          => 'required|string|max:200',
            'description'  => 'required|string',
            'duree_annees' => 'required|integer|min:1',
            'mode_entree'  => 'required|in:classement,concours,dossier,direct',
            'quota_bourse' => 'required|integer|min:0',
            'quota_aide_fpp' => 'required|integer|min:0',
            'seuil_bourse' => 'required|numeric|min:0|max:20',
            'campus'       => 'required|array|min:1',
            'series'       => 'required|array|min:1',
        ]);

        // Créer la filière directement validée par l'admin
        $filiere = Filiere::create([
            'nom'            => $request->nom,
            'description'    => $request->description,
            'duree_annees'   => $request->duree_annees,
            'mode_entree'    => $request->mode_entree,
            'quota_bourse'   => $request->quota_bourse,
            'quota_aide_fpp' => $request->quota_aide_fpp,
            'statut'         => 'validee',
        ]);

        // Lier aux campus
        foreach ($request->campus as $id_campus) {
            DB::table('uni_filieres')->insert([
                'id_campus'    => $id_campus,
                'id_filiere'   => $filiere->id_filiere,
                'id_annee'     => 1,
                'quota_bourse' => $request->quota_bourse,
                'seuil_bourse' => $request->seuil_bourse,
            ]);
        }

        // Lier aux séries
        foreach ($request->series as $id_serie) {
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

        $request->validate([
            'nom' => 'required|string|max:200',
            'description' => 'required|string',
            'statut' => 'required|in:en_attente,validee,rejetee',
        ]);

        $filiere = Filiere::findOrFail($id);
        $filiere->update($request->only(['nom', 'description', 'statut']));

        return redirect()->route('admin.filieres')
                         ->with('success', 'Filière mise à jour !');
    }

    public function valider($id)
    {
        if ($r = $this->checkAuth()) return $r;
        Filiere::findOrFail($id)->update(['statut' => 'validee', 'motif_rejet' => null]);
        return back()->with('success', 'Filière validée !');
    }

    public function rejeter(Request $request, $id)
    {
        if ($r = $this->checkAuth()) return $r;
        $request->validate(['motif' => 'required|string']);
        Filiere::findOrFail($id)->update([
            'statut'      => 'rejetee',
            'motif_rejet' => $request->motif,
        ]);
        return back()->with('success', 'Filière rejetée.');
    }

    public function destroy($id)
    {
        if ($r = $this->checkAuth()) return $r;
        Filiere::findOrFail($id)->delete();
        return back()->with('success', 'Filière supprimée.');
    }
}