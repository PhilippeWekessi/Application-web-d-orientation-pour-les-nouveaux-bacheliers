<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Temoignage;

class AccueilController extends Controller
{
    public function index()
    {
        $filieres = Filiere::take(8)->get();
        $temoignages = Temoignage::where('statut', 'valide')
                        ->with(['user', 'filiere'])
                        ->take(3)
                        ->get();

        return view('accueil', compact('filieres', 'temoignages'));
    }
}