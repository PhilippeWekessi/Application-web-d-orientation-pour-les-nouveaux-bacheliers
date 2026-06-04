<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Temoignage;

class AccueilController extends Controller
{
    public function index()
    {
        // Charger les filieres sans relations (qui causent des timeouts)
        $filieres = Filiere::take(8)->get();

        // Récupérer les témoignages valides avec vérification des relations
        $temoignages = Temoignage::where('statut', 'valide')
                        ->whereHas('user')
                        ->whereHas('filiere')
                        ->with(['user', 'filiere'])
                        ->take(3)
                        ->get();

        return view('accueil', compact('filieres', 'temoignages'));
    }
}