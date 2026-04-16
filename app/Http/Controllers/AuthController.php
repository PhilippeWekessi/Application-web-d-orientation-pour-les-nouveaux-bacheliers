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
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Session::put('user_id', $user->id_user);
            Session::put('user_nom', $user->nom);
            Session::put('user_prenom', $user->prenom);
            return redirect()->route('accueil')
                             ->with('success', 'Bienvenue ' . $user->prenom . ' !');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.'])
                     ->withInput();
    }

    public function registerForm()
    {
        $series = Serie::orderBy('code')->get();
        return view('auth.register', compact('series'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom'      => 'required|string|max:100',
            'prenom'   => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'nom'      => $request->nom,
            'prenom'   => $request->prenom,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'id_serie' => $request->id_serie ?: null,
        ]);

        Session::put('user_id', $user->id_user);
        Session::put('user_nom', $user->nom);
        Session::put('user_prenom', $user->prenom);

        return redirect()->route('questionnaire')
                         ->with('success', 'Compte créé avec succès !');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('accueil')
                         ->with('success', 'Vous êtes déconnecté.');
    }
}