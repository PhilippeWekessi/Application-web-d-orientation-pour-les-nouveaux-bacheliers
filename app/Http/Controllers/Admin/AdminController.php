<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Universite;
use App\Models\Temoignage;
use App\Models\Actualite;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Vérifier que l'admin est connecté
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        $totalFilieres      = Filiere::count();
        $filiersEnAttente   = Filiere::where('statut', 'en_attente')->count();
        $totalUniversites   = Universite::count();
        $universitesEnAttente = Universite::where('statut', 'en_attente')->count();
        $totalTemoignages   = Temoignage::where('statut', 'valide')->count();
        $temoignagesEnAttente = Temoignage::where('statut', 'en_attente')->count();
        $totalActualites    = Actualite::count();

        $dernieresFilieres  = Filiere::with('campus')->latest()->take(5)->get();
        $dernieresUniversites = Universite::latest()->take(5)->get();
        $temoignagesPendants = Temoignage::where('statut', 'en_attente')
                                ->with(['user', 'filiere'])
                                ->take(5)->get();

        // Activités récentes simulées
        // Remplace les deux foreach par ceci :
        $activites = [];
        foreach (Filiere::latest()->take(2)->get() as $f) {
            $activites[] = [
                'couleur' => 'green',
                'texte'   => 'Filière <strong>' . $f->nom . '</strong> ajoutée',
                'temps'   => $f->created_at ? $f->created_at->diffForHumans() : 'Récemment',
            ];
        }
        foreach (Temoignage::where('statut', 'en_attente')->take(2)->get() as $t) {
            $activites[] = [
                'couleur' => 'yellow',
                'texte'   => 'Témoignage en attente de validation',
                'temps'   => $t->created_at ? $t->created_at->diffForHumans() : 'Récemment',
            ];
        }
        
        return view('admin.dashboard', compact(
            'totalFilieres', 'filiersEnAttente', 'totalUniversites', 'universitesEnAttente',
            'totalTemoignages', 'temoignagesEnAttente', 'totalActualites',
            'dernieresFilieres', 'dernieresUniversites', 'temoignagesPendants', 'activites'
        ));
    }
}