<?php
namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Universite;
use App\Models\Actualite;
use App\Models\Abonnement;

class ProfilController extends Controller
{
    public function dashboard()
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $userId = session('user_id');

        // Correction : on supprime le filtre 'statut' si ta table n'a pas ce champ
        $totalFilieres    = Filiere::count();
        $totalUniversites = Universite::count();
        $totalActualites  = Actualite::count();

        $actualites = Actualite::latest()->take(4)->get();

        $abonnementsIds = Abonnement::where('id_user', $userId)
                            ->pluck('id_actualite');

        $nbAbonnements = $abonnementsIds->count();

        return view('profil.dashboard', compact(
            'totalFilieres', 'totalUniversites', 'totalActualites',
            'actualites', 'abonnementsIds', 'nbAbonnements'
        ));
    }
}