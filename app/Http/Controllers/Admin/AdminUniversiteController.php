<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Universite;
use App\Models\Campus;
use App\Models\Responsable;
use Illuminate\Http\Request;

class AdminUniversiteController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_id')) return redirect()->route('admin.login');
        return null;
    }

    public function index(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        $query = Universite::withCount('campus');

        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $universites    = $query->latest()->paginate(20);
        $totalEnAttente = Universite::where('statut', 'en_attente')->count();
        $totalPrivees   = Universite::where('type', 'prive')->count();
        $totalPubliques = Universite::where('type', 'public')->count();
        $total          = Universite::count();

        // Charger les responsables en une seule requête (évite N+1)
        $responsables = Responsable::whereNotNull('id_universite')
            ->get()
            ->keyBy('id_universite');

        return view('admin.universites.index', compact(
            'universites', 'totalEnAttente', 'totalPrivees',
            'totalPubliques', 'total', 'responsables'
        ));
    }

    public function create()
    {
        if ($r = $this->checkAuth()) return $r;
        return view('admin.universites.create');
    }

    public function valider($id)
    {
        if ($r = $this->checkAuth()) return $r;

        $universite = Universite::findOrFail($id);
        $universite->update(['statut' => 'validee']);

        if ($universite->campus()->count() === 0) {
            Campus::create([
                'nom'           => $universite->nom . ' - Campus Principal',
                'adresse'       => 'À spécifier',
                'ville'         => $universite->ville,
                'id_universite' => $universite->id_universite,
            ]);
        }

        return back()->with('success', "L'université \"{$universite->nom}\" a été validée !");
    }

    public function rejeter(Request $request, $id)
    {
        if ($r = $this->checkAuth()) return $r;

        $universite = Universite::findOrFail($id);
        $universite->update([
            'statut'      => 'rejetee',
            'motif_rejet' => $request->motif ?? null,
        ]);

        return back()->with('success', "L'université \"{$universite->nom}\" a été rejetée.");
    }

    public function destroy($id)
    {
        if ($r = $this->checkAuth()) return $r;
        Universite::findOrFail($id)->delete();
        return back()->with('success', 'Université supprimée avec succès.');
    }

    public function show($id)
    {
        if ($r = $this->checkAuth()) return $r;

        $universite   = Universite::with(['campus.filieres'])->findOrFail($id);
        $responsable  = Responsable::where('id_universite', $id)->first();
        $responsables = Responsable::whereNull('id_universite')
                            ->orWhere('id_universite', $id)
                            ->orderBy('nom')
                            ->get();

        $filieres = collect();
        foreach ($universite->campus as $campus) {
            $filieres = $filieres->merge($campus->filieres);
        }

        return view('admin.universites.show', compact(
            'universite', 'filieres', 'responsable', 'responsables'
        ));
    }

    public function assignerResponsable(Request $request, $id)
    {
        if ($r = $this->checkAuth()) return $r;

        $universite = Universite::findOrFail($id);

        // Désassigner l'ancien responsable de cette université
        Responsable::where('id_universite', $id)
            ->update(['id_universite' => null]);

        // Assigner le nouveau responsable
        if ($request->id_responsable) {
            Responsable::where('id_responsable', $request->id_responsable)
                ->update(['id_universite' => $id]);
        }

        return back()->with('success', 'Responsable assigné avec succès à ' . $universite->nom);
    }
}