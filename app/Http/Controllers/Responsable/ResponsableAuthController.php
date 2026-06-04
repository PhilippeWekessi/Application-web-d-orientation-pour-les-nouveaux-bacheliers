<?php
namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use App\Models\Responsable;
use App\Models\Universite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ResponsableAuthController extends Controller
{
    public function loginForm()
    {
        if (session('responsable_id')) {
            return redirect()->route('responsable.dashboard');
        }
        return view('responsable.auth.login');
    }

    public function login(Request $request)
    {
        // Validation manuelle pour éviter le timeout
        $email = trim($request->input('email', ''));
        $password = trim($request->input('password', ''));

        if (empty($email) || empty($password)) {
            return back()->withErrors([
                'email' => 'Email et mot de passe sont requis.'
            ])->withInput();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors([
                'email' => 'Email invalide.'
            ])->withInput();
        }

        $responsable = Responsable::with('universite')
                        ->where('email', $email)
                        ->first();

        if (!$responsable || !Hash::check($password, $responsable->password)) {
            return back()->withErrors([
                'email' => 'Email ou mot de passe incorrect.'
            ])->withInput();
        }

        // ✅ Plus de vérification de statut — tous les comptes sont actifs
        Session::put('responsable_id',          $responsable->id_responsable);
        Session::put('responsable_nom',         $responsable->nom);
        Session::put('responsable_prenom',      $responsable->prenom);
        Session::put('responsable_email',       $responsable->email);
        Session::put('responsable_universite',  $responsable->universite?->nom ?? '');
        Session::put('responsable_id_universite', $responsable->id_universite);
        Session::put('responsable_photo',       $responsable->photo);

        return redirect()->route('responsable.dashboard')
                         ->with('success', 'Bienvenue ' . $responsable->prenom . ' !');
    }

    public function registerForm()
    {
        if (session('responsable_id')) {
            return redirect()->route('responsable.dashboard');
        }
        $universites = Universite::orderBy('nom')->get();
        return view('responsable.auth.register', compact('universites'));
    }

    public function register(Request $request)
    {
        // Validation manuelle pour éviter le timeout
        $nom = trim($request->input('nom', ''));
        $prenom = trim($request->input('prenom', ''));
        $email = trim($request->input('email', ''));
        $password = trim($request->input('password', ''));
        $password_confirmation = trim($request->input('password_confirmation', ''));
        $telephone = trim($request->input('telephone', ''));

        $errors = [];

        if (empty($nom)) {
            $errors['nom'] = 'Le nom est requis.';
        } elseif (strlen($nom) > 100) {
            $errors['nom'] = 'Le nom ne doit pas dépasser 100 caractères.';
        }

        if (empty($prenom)) {
            $errors['prenom'] = 'Le prénom est requis.';
        } elseif (strlen($prenom) > 100) {
            $errors['prenom'] = 'Le prénom ne doit pas dépasser 100 caractères.';
        }

        if (empty($email)) {
            $errors['email'] = 'L\'email est requis.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'L\'email doit être valide.';
        } elseif (strlen($email) > 150) {
            $errors['email'] = 'L\'email ne doit pas dépasser 150 caractères.';
        } elseif (Responsable::where('email', $email)->exists()) {
            $errors['email'] = 'Cet email est déjà utilisé.';
        }

        if (empty($password)) {
            $errors['password'] = 'Le mot de passe est requis.';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Le mot de passe doit contenir au moins 6 caractères.';
        } elseif ($password !== $password_confirmation) {
            $errors['password'] = 'La confirmation du mot de passe ne correspond pas.';
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
            'id_universite' => null, // ← pas encore d'université
            'statut'        => 'actif',
        ]);

        return redirect()->route('responsable.login')
                        ->with('success', 'Compte créé ! Connectez-vous pour enregistrer votre université.');
    }

    public function logout()
    {
        Session::forget([
            'responsable_id',
            'responsable_nom',
            'responsable_prenom',
            'responsable_email',
            'responsable_universite',
            'responsable_id_universite',
            'responsable_photo',
        ]);
        return redirect()->route('responsable.login')
                         ->with('success', 'Vous êtes déconnecté.');
    }

    public function forgotForm()
    {
        if (session('responsable_id')) {
            return redirect()->route('responsable.dashboard');
        }

        return view('auth.passwords.request', [
            'title' => 'Mot de passe oublié - Responsable',
            'description' => 'Entrez l’adresse email de votre compte responsable.',
            'submitRoute' => 'responsable.password.email',
            'backRoute' => 'responsable.login',
        ]);
    }

    public function forgotSubmit(Request $request)
    {
        $email = trim($request->input('email', ''));
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors(['email' => 'Email invalide.'])->withInput();
        }

        $responsable = Responsable::where('email', $email)->first();
        if (! $responsable) {
            return back()->withErrors(['email' => 'Aucun compte responsable trouvé pour cette adresse.'])->withInput();
        }

        return redirect()->route('responsable.password.reset', ['email' => $email])
                         ->with('success', 'Adresse reconnue. Choisissez un nouveau mot de passe.');
    }

    public function resetForm(Request $request)
    {
        if (session('responsable_id')) {
            return redirect()->route('responsable.dashboard');
        }

        return view('auth.passwords.reset', [
            'title' => 'Réinitialiser le mot de passe - Responsable',
            'description' => 'Choisissez un nouveau mot de passe pour votre compte responsable.',
            'submitRoute' => 'responsable.password.update',
            'backRoute' => 'responsable.login',
            'email' => $request->query('email'),
        ]);
    }

    public function resetSubmit(Request $request)
    {
        // Validation manuelle pour éviter le timeout
        $email = trim($request->input('email', ''));
        $password = trim($request->input('password', ''));
        $password_confirmation = trim($request->input('password_confirmation', ''));

        $errors = [];

        if (empty($email)) {
            $errors['email'] = 'L\'email est requis.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'L\'email doit être valide.';
        }

        if (empty($password)) {
            $errors['password'] = 'Le mot de passe est requis.';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Le mot de passe doit contenir au moins 6 caractères.';
        } elseif ($password !== $password_confirmation) {
            $errors['password'] = 'La confirmation du mot de passe ne correspond pas.';
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        $responsable = Responsable::where('email', $email)->first();
        if (!$responsable) {
            return back()->withErrors(['email' => 'Aucun compte trouvé pour cet email.'])->withInput();
        }

        $responsable->update(['password' => Hash::make($password)]);

        return redirect()->route('responsable.login')
                         ->with('success', 'Mot de passe réinitialisé. Connectez-vous avec votre nouveau mot de passe.');
    }
}
