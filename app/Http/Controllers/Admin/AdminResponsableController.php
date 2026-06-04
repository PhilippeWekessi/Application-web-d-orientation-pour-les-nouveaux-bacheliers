<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Responsable;
use App\Models\Universite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminResponsableController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_id')) return redirect()->route('admin.login');
        return null;
    }

    // Liste tous les responsables
    public function index()
    {
        if ($r = $this->checkAuth()) return $r;
        $responsables = Responsable::with('universite')->latest()->get();
        return view('admin.responsables.index', compact('responsables'));
    }

    // Formulaire création depuis l'admin
    public function create()
    {
        if ($r = $this->checkAuth()) return $r;
        $universites = Universite::orderBy('nom')->get();
        return view('admin.responsables.create', compact('universites'));
    }

    // Créer depuis l'admin → actif directement
    public function store(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        // Validation manuelle
        $nom = trim($request->input('nom', ''));
        $prenom = trim($request->input('prenom', ''));
        $email = trim($request->input('email', ''));
        $password = trim($request->input('password', ''));
        $id_universite = $request->input('id_universite');
        $fonction = trim($request->input('fonction', ''));
        $telephone = trim($request->input('telephone', ''));

        $errors = [];
        if (empty($nom) || strlen($nom) > 100) {
            $errors['nom'] = 'Le nom est requis (max 100 caractères).';
        }
        if (empty($prenom) || strlen($prenom) > 100) {
            $errors['prenom'] = 'Le prénom est requis (max 100 caractères).';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email invalide.';
        } else {
            $exists = Responsable::where('email', $email)->exists();
            if ($exists) {
                $errors['email'] = 'Cet email est déjà utilisé.';
            }
        }
        if (empty($password) || strlen($password) < 6) {
            $errors['password'] = 'Le mot de passe doit contenir au moins 6 caractères.';
        }
        if (empty($id_universite)) {
            $errors['id_universite'] = 'L\'université est requise.';
        } else {
            $uni = Universite::where('id_universite', $id_universite)->first();
            if (!$uni) {
                $errors['id_universite'] = 'L\'université sélectionnée est invalide.';
            }
        }
        if (!empty($fonction) && strlen($fonction) > 100) {
            $errors['fonction'] = 'La fonction ne doit pas dépasser 100 caractères.';
        }
        if (!empty($telephone) && strlen($telephone) > 20) {
            $errors['telephone'] = 'Le téléphone ne doit pas dépasser 20 caractères.';
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        Responsable::create([
            'nom'           => $nom,
            'prenom'        => $prenom,
            'email'         => $email,
            'password'      => Hash::make($password),
            'telephone'     => $telephone ?: null,
            'fonction'      => $fonction ?: null,
            'id_universite' => $id_universite,
            'statut'        => 'actif', // ✅ Toujours actif
        ]);

        return redirect()->route('admin.responsables')
                         ->with('success', 'Compte responsable créé avec succès !');
    }

    // ✅ Activer un compte (si désactivé)
    public function valider($id)
    {
        if ($r = $this->checkAuth()) return $r;
        Responsable::findOrFail($id)->update(['statut' => 'actif']);
        return back()->with('success', 'Compte activé !');
    }

    // ✅ Désactiver un compte
    public function rejeter($id)
    {
        if ($r = $this->checkAuth()) return $r;
        Responsable::findOrFail($id)->update(['statut' => 'inactif']);
        return back()->with('success', 'Compte désactivé.');
    }
}