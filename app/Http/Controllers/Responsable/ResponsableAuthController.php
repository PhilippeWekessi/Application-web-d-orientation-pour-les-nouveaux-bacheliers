<?php
namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use App\Models\Responsable;
use App\Models\Universite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResponsableAuthController extends Controller
{
    public function registerForm()
    {
        $universites = Universite::where('type', 'prive')->orWhere('type', 'agree')->get();
        // Si pas d'université privée encore, prendre toutes
        if ($universites->isEmpty()) {
            $universites = Universite::all();
        }
        return view('responsable.register', compact('universites'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom'            => 'required|string|max:100',
            'prenom'         => 'required|string|max:100',
            'email'          => 'required|email|unique:responsables,email',
            'password'       => 'required|min:6|confirmed',
            'telephone'      => 'required|string|max:20',
            'fonction'       => 'required|string|max:100',
            'nom_universite' => 'required|string|max:200',
            'sigle'          => 'required|string|max:30',
            'ville'          => 'required|string|max:100',
            'adresse'        => 'required|string',
            'description'    => 'nullable|string',
        ]);

        // Créer l'université privée avec statut en attente
        $universite = Universite::create([
            'nom'      => $request->nom_universite,
            'sigle'    => $request->sigle,
            'ville'    => $request->ville,
            'type'     => 'prive',
            'latitude' => null,
            'longitude'=> null,
            'id_annee' => 1,
        ]);

        // Créer le compte responsable
        $responsable = Responsable::create([
            'nom'           => $request->nom,
            'prenom'        => $request->prenom,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'telephone'     => $request->telephone,
            'fonction'      => $request->fonction,
            'id_universite' => $universite->id_universite,
            'statut'        => 'en_attente',
        ]);

        return redirect()->route('responsable.login')
                         ->with('success', 'Votre compte a été créé. Un administrateur va valider votre accès sous peu.');
    }

    public function loginForm()
    {
        if (session('responsable_id')) {
            return redirect()->route('responsable.dashboard');
        }
        return view('responsable.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $responsable = Responsable::where('email', $request->email)->first();

        if (!$responsable || !Hash::check($request->password, $responsable->password)) {
            return back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
        }

        if ($responsable->statut === 'en_attente') {
            return back()->withErrors(['email' => 'Votre compte est en attente de validation par l\'administrateur.']);
        }

        if ($responsable->statut === 'inactif') {
            return back()->withErrors(['email' => 'Votre compte a été désactivé.']);
        }

        session([
            'responsable_id'     => $responsable->id_responsable,
            'responsable_nom'    => $responsable->nom,
            'responsable_prenom' => $responsable->prenom,
            'responsable_uni'    => $responsable->id_universite,
        ]);

        return redirect()->route('responsable.dashboard');
    }

    public function logout()
    {
        session()->forget(['responsable_id', 'responsable_nom', 'responsable_prenom', 'responsable_uni']);
        return redirect()->route('responsable.login');
    }
}