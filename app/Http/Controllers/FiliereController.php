<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Serie;
use App\Models\Universite;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function index(Request $request)
    {
        $query = Filiere::with(['campus.universite', 'series'])
                ->where('statut', 'validee');

        if ($request->search) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        if ($request->series) {
            $query->whereHas('series', function($q) use ($request) {
                $q->whereIn('series.id_serie', $request->series);
            });
        }

        if ($request->universite) {
            $query->whereHas('campus.universite', function($q) use ($request) {
                $q->where('id_universite', $request->universite);
            });
        }

        if ($request->mode) {
            $query->whereIn('mode_entree', $request->mode);
        }

        if ($request->duree) {
            $query->whereIn('duree_annees', $request->duree);
        }

        if ($request->bourse) {
            $query->where('quota_bourse', '>', 0);
        }

        if ($request->fpp) {
            $query->where('quota_aide_fpp', '>', 0);
        }

        switch ($request->sort) {
            case 'bourse':
                $query->orderBy('quota_bourse', 'desc');
                break;
            case 'duree':
                $query->orderBy('duree_annees');
                break;
            case 'alpha':
                $query->orderBy('nom');
                break;
            default:
                $query->orderBy('nom');
        }

        $filieres = $query->paginate(10);
        $series = Serie::all();
        $universites = Universite::all();

        return view('filieres.index', compact('filieres', 'series', 'universites'));
    }

    public function show($id)
    {
        $filiere = Filiere::with([
            'campus.universite',
            'series',
            'debouches',
            'interets',
            'temoignages.user.serie',
        ])->findOrFail($id);

        $serie = $filiere->series->first();
        $matieres = collect();

        if ($serie) {
            $matieres = \App\Models\Matiere::join('filiere_serie_matieres', 'matieres.id_matieres', '=', 'filiere_serie_matieres.id_matiere') // ← corrigé
                ->where('filiere_serie_matieres.id_filiere', $filiere->id_filiere)
                ->where('filiere_serie_matieres.id_serie', $serie->id_serie)
                ->select('matieres.*', 'filiere_serie_matieres.coefficient')
                ->get()
                ->map(function($m) {
                    $m->pivot = (object)['coefficient' => $m->coefficient];
                    return $m;
                });
        }

        $uniFiliere = \App\Models\UniFiliere::where('id_filiere', $filiere->id_filiere)->first();

        $temoignages = \App\Models\Temoignage::where('id_filiere', $filiere->id_filiere)
                        ->where('statut', 'valide')
                        ->with('user.serie')
                        ->take(3)
                        ->get();

        return view('filieres.show', compact('filiere', 'matieres', 'uniFiliere', 'temoignages'));
    }

    public function campus() {
        return $this->belongsToMany(Campus::class, 'uni_filieres', 'id_filiere', 'id_campus')
                    ->with('universite');
    }
}