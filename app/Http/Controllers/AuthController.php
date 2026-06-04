<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (session('user_id')) {
            return redirect()->route('profil');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validation manuelle pour éviter le timeout
        $email = trim($request->input('email', ''));
        $password = trim($request->input('password', ''));

        if (empty($email) || empty($password)) {
            return back()->withErrors(['email' => 'Email et mot de passe sont requis.'])->withInput();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors(['email' => 'Email invalide.'])->withInput();
        }

        $user = User::with('serie')->where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return back()->withErrors(['email' => 'Email ou mot de passe incorrect.'])->withInput();
        }

        // Stocker toutes les infos nécessaires en session
        Session::put('user_id',     $user->id_user);
        Session::put('user_nom',    $user->nom);
        Session::put('user_prenom', $user->prenom);
        Session::put('user_email',  $user->email);
        Session::put('user_serie',  $user->serie?->code ?? null);
        Session::put('user_photo',  $user->photo);

        if ($user->questionnaire_data) {
            Session::put('questionnaire', is_string($user->questionnaire_data)
                ? json_decode($user->questionnaire_data, true)
                : $user->questionnaire_data);
        }

        return redirect()->route('profil')
                         ->with('success', 'Bienvenue ' . $user->prenom . ' !');
    }

    public function registerForm()
    {
        if (session('user_id')) {
            return redirect()->route('profil');
        }
        $series = Serie::orderBy('code')->get();
        return view('auth.register', compact('series'));
    }

    public function register(Request $request)
    {
        // Validation manuelle
        $nom = trim($request->input('nom', ''));
        $prenom = trim($request->input('prenom', ''));
        $email = trim($request->input('email', ''));
        $password = trim($request->input('password', ''));
        $password_confirmation = trim($request->input('password_confirmation', ''));

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
            $exists = User::where('email', $email)->exists();
            if ($exists) {
                $errors['email'] = 'Cet email est déjà utilisé.';
            }
        }
        if (empty($password) || strlen($password) < 6) {
            $errors['password'] = 'Le mot de passe doit contenir au moins 6 caractères.';
        }
        if ($password !== $password_confirmation) {
            $errors['password'] = 'La confirmation ne correspond pas.';
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        $user = User::create([
            'nom'      => $nom,
            'prenom'   => $prenom,
            'email'    => $email,
            'password' => Hash::make($password),
            'id_serie' => $request->id_serie ?: null,
            'questionnaire_data' => session('questionnaire') ?: null,
        ]);

        // Redirection vers login après inscription
        return redirect()->route('login')
                         ->with('success', 'Compte créé avec succès ! Connectez-vous maintenant.');
    }

    public function logout()
    {
        Session::forget(['user_id', 'user_nom', 'user_prenom', 'user_email', 'user_serie', 'user_photo']);
        return redirect()->route('accueil')
                         ->with('success', 'Vous êtes déconnecté.');
    }

    public function editProfile()
    {
        if (! session('user_id')) {
            return redirect()->route('login');
        }

        $user = User::find(session('user_id'));
        return view('profil.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if (! session('user_id')) {
            return redirect()->route('login');
        }

        $user = User::find(session('user_id'));

        // Validation manuelle
        $nom = trim($request->input('nom', ''));
        $prenom = trim($request->input('prenom', ''));
        $password = trim($request->input('password', ''));
        $password_confirmation = trim($request->input('password_confirmation', ''));

        $errors = [];
        if (empty($nom) || strlen($nom) > 100) {
            $errors['nom'] = 'Le nom est requis (max 100 caractères).';
        }
        if (empty($prenom) || strlen($prenom) > 100) {
            $errors['prenom'] = 'Le prénom est requis (max 100 caractères).';
        }

        if (!empty($password)) {
            if (strlen($password) < 6) {
                $errors['password'] = 'Le mot de passe doit contenir au moins 6 caractères.';
            } elseif ($password !== $password_confirmation) {
                $errors['password'] = 'La confirmation ne correspond pas.';
            }
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        $user->nom = $nom;
        $user->prenom = $prenom;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            // Vérifier que c'est une image
            $mimeType = $file->getMimeType();
            if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
                return back()->withErrors(['photo' => 'Le fichier doit être une image.'])->withInput();
            }
            if ($file->getSize() > 2048000) {  // 2MB
                return back()->withErrors(['photo' => 'L\'image ne doit pas dépasser 2MB.'])->withInput();
            }
            $filename = 'user_' . session('user_id') . '_' . time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/users');
            if (! file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $user->photo = 'uploads/users/' . $filename;
        }

        if (!empty($password)) {
            $user->password = Hash::make($password);
        }

        $user->save();

        Session::put('user_nom', $user->nom);
        Session::put('user_photo', $user->photo);
        Session::put('user_prenom', $user->prenom);

        return redirect()->route('profil.edit')
                         ->with('success', 'Profil mis à jour avec succès.');
    }

    public function forgotForm()
    {
        if (session('user_id')) {
            return redirect()->route('profil');
        }

        return view('auth.passwords.request', [
            'title' => 'Mot de passe oublié',
            'description' => 'Entrez votre adresse email pour réinitialiser votre mot de passe.',
            'submitRoute' => 'password.email',
            'backRoute' => 'login',
        ]);
    }

    public function forgotSubmit(Request $request)
    {
        $email = trim($request->input('email', ''));
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors(['email' => 'Email invalide.'])->withInput();
        }

        $user = User::where('email', $email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'Aucun compte trouvé pour cette adresse.'])->withInput();
        }

        return redirect()->route('password.reset', ['email' => $email])
                         ->with('success', 'Adresse reconnue. Choisissez un nouveau mot de passe.');
    }

    public function resetForm(Request $request)
    {
        if (session('user_id')) {
            return redirect()->route('profil');
        }

        return view('auth.passwords.reset', [
            'title' => 'Réinitialiser le mot de passe',
            'description' => 'Choisissez un nouveau mot de passe pour votre compte.',
            'submitRoute' => 'password.update',
            'backRoute' => 'login',
            'email' => $request->query('email'),
        ]);
    }

    public function resetSubmit(Request $request)
    {
        $email = trim($request->input('email', ''));
        $password = trim($request->input('password', ''));
        $password_confirmation = trim($request->input('password_confirmation', ''));

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors(['email' => 'Email invalide.'])->withInput();
        }
        if (empty($password) || strlen($password) < 6) {
            return back()->withErrors(['password' => 'Le mot de passe doit contenir au moins 6 caractères.'])->withInput();
        }
        if ($password !== $password_confirmation) {
            return back()->withErrors(['password' => 'La confirmation ne correspond pas.'])->withInput();
        }

        $user = User::where('email', $email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'Aucun compte trouvé pour cette adresse.'])->withInput();
        }

        $user->password = Hash::make($password);
        $user->save();

        return redirect()->route('login')
                         ->with('success', 'Mot de passe mis à jour. Vous pouvez maintenant vous connecter.');
    }
}