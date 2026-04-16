<?php

namespace App\Http\Controllers;

use App\Models\Universite;
use App\Models\Filiere;
use Illuminate\Http\Request;

class UniversiteController extends Controller
{
    public function index(Request $request)
    {
        $query = Universite::with(['campus.filieres']);

        // Recherche
        if ($request->search) {
            $query->where('nom', 'like', '%' . $request->search . '%')
                  ->orWhere('sigle', 'like', '%' . $request->search . '%');
        }

        // Filtre type
        if ($request->type) {
            $query->where('type', $request->type);
        }

        // Filtre ville
        if ($request->ville) {
            $query->where('ville', 'like', '%' . $request->ville . '%');
        }

        // Tri
        switch ($request->sort) {
            case 'alpha':
                $query->orderBy('nom');
                break;
            default:
                $query->orderBy('nom');
        }

        $universites = $query->paginate(9);

        // Stats
        $totalUniversites = Universite::count();
        $totalPublics = Universite::where('type', 'public')->count();
        $totalFilieres = Filiere::count();
        $totalVilles = Universite::distinct()->pluck('ville');
        $villes = $totalVilles;
        $totalVilles = $villes->count();

        return view('universites.index', compact(
            'universites', 'totalUniversites', 'totalPublics',
            'totalFilieres', 'totalVilles', 'villes'
        ));
    }

    public function show($id)
    {
        $universite = Universite::with(['campus.filieres.series', 'campus.filieres.debouches'])
                                ->findOrFail($id);

        return view('universites.show', compact('universite'));
    }
}