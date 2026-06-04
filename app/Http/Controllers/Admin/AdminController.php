<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Universite;
use App\Models\Temoignage;
use App\Models\Actualite;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function profil()
    {
        // Vérifier que l'admin est connecté
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        return view('admin.profil');
    }

    public function updateProfil(Request $request)
    {
        // Vérifier que l'admin est connecté
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $admin = Admin::find(session('admin_id'));

            if (!$admin) {
                return redirect()->route('admin.profil')->with('error', 'Administrateur non trouvé.');
            }

            // Gestion de la photo
            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
                    Storage::disk('public')->delete($admin->photo);
                }

                // Sauvegarder la nouvelle photo
                $photoPath = $request->file('photo')->store('uploads', 'public');
                $admin->photo = $photoPath;
            }

            // Mettre à jour les informations
            $admin->prenom = $request->prenom;
            $admin->nom = $request->nom;
            $admin->save();

            // Mettre à jour la session
            session([
                'admin_nom' => $admin->nom,
                'admin_prenom' => $admin->prenom,
                'admin_photo' => $admin->photo,
            ]);

            return redirect()->route('admin.profil')->with('success', 'Profil mis à jour avec succès.');

        } catch (\Exception $e) {
            return redirect()->route('admin.profil')->with('error', 'Erreur lors de la mise à jour du profil.');
        }
    }
}