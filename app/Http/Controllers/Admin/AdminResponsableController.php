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

    public function index()
    {
        if ($r = $this->checkAuth()) return $r;
        $responsables = Responsable::with('universite')->latest()->get();
        return view('admin.responsables.index', compact('responsables'));
    }

    public function create()
    {
        if ($r = $this->checkAuth()) return $r;
        $universites = Universite::orderBy('nom')->get();
        return view('admin.responsables.create', compact('universites'));
    }

    public function store(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        $request->validate([
            'nom'           => 'required|string|max:100',
            'prenom'        => 'required|string|max:100',
            'email'         => 'required|email|unique:responsables,email',
            'password'      => 'required|min:6',
            'id_universite' => 'required|exists:universites,id_universite',
            'fonction'      => 'nullable|string|max:100',
            'telephone'     => 'nullable|string|max:20',
        ]);

        Responsable::create([
            'nom'           => $request->nom,
            'prenom'        => $request->prenom,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'telephone'     => $request->telephone,
            'fonction'      => $request->fonction,
            'id_universite' => $request->id_universite,
            'statut'        => 'actif',
        ]);

        return redirect()->route('admin.responsables')
                         ->with('success', 'Compte responsable créé avec succès !');
    }

    public function valider($id)
    {
        if ($r = $this->checkAuth()) return $r;
        Responsable::findOrFail($id)->update(['statut' => 'actif']);
        return back()->with('success', 'Compte validé !');
    }

    public function rejeter($id)
    {
        if ($r = $this->checkAuth()) return $r;
        Responsable::findOrFail($id)->update(['statut' => 'inactif']);
        return back()->with('success', 'Compte désactivé.');
    }
}