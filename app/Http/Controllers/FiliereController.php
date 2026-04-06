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
        $query = Filiere::with(['campus.universite', 'series']);

        // Recherche par nom
        if ($request->search) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        // Filtre par série
        if ($request->series) {
            $query->whereHas('series', function($q) use ($request) {
                $q->whereIn('series.id_serie', $request->series);
            });
        }

        // Filtre par université
        if ($request->universite) {
            $query->whereHas('campus.universite', function($q) use ($request) {
                $q->where('id_universite', $request->universite);
            });
        }

        // Filtre par mode d'entrée
        if ($request->mode) {
            $query->whereIn('mode_entree', $request->mode);
        }

        // Filtre par durée
        if ($request->duree) {
            $query->whereIn('duree_annees', $request->duree);
        }

        // Filtre bourse
        if ($request->bourse) {
            $query->where('quota_bourse', '>', 0);
        }

        // Filtre FPP
        if ($request->fpp) {
            $query->where('quota_aide_fpp', '>', 0);
        }

        // Tri
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
            'interets'
        ])->findOrFail($id);

        return view('filieres.show', compact('filiere'));
    }

    public function campus() {
        return $this->belongsToMany(Campus::class, 'uni_filieres', 'id_filiere', 'id_campus')
                    ->with('universite');
    }
}