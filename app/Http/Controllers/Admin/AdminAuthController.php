<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function loginForm()
    {
        if (session('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
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

        $admin = Admin::where('email', $email)->first();

        if ($admin && Hash::check($password, $admin->password)) {
            session([
                'admin_id'     => $admin->id_admin,
                'admin_nom'    => $admin->nom,
                'admin_prenom' => $admin->prenom,
                'admin_photo'  => $admin->photo,
            ]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.'])->withInput();
    }

    public function logout()
    {
        session()->forget(['admin_id', 'admin_nom', 'admin_prenom', 'admin_photo']);
        return redirect()->route('admin.login');
    }

    public function forgotForm()
    {
        if (session('admin_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.passwords.request', [
            'title' => 'Mot de passe oublié - Admin',
            'description' => 'Entrez l’adresse email de votre compte administrateur.',
            'submitRoute' => 'admin.password.email',
            'backRoute' => 'admin.login',
        ]);
    }

    public function forgotSubmit(Request $request)
    {
        $email = trim($request->input('email', ''));
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors(['email' => 'Email invalide.'])->withInput();
        }

        $admin = Admin::where('email', $email)->first();
        if (! $admin) {
            return back()->withErrors(['email' => 'Aucun compte administrateur trouvé pour cette adresse.'])->withInput();
        }

        return redirect()->route('admin.password.reset', ['email' => $email])
                         ->with('success', 'Adresse reconnue. Choisissez un nouveau mot de passe.');
    }

    public function resetForm(Request $request)
    {
        if (session('admin_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.passwords.reset', [
            'title' => 'Réinitialiser le mot de passe - Admin',
            'description' => 'Choisissez un nouveau mot de passe pour votre compte administrateur.',
            'submitRoute' => 'admin.password.update',
            'backRoute' => 'admin.login',
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

        $admin = Admin::where('email', $email)->first();
        if (! $admin) {
            return back()->withErrors(['email' => 'Aucun compte administrateur trouvé.'])->withInput();
        }

        $admin->password = Hash::make($password);
        $admin->save();

        return redirect()->route('admin.login')
                         ->with('success', 'Mot de passe administrateur mis à jour. Vous pouvez maintenant vous connecter.');
    }
}