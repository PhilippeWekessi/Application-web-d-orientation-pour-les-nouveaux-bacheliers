<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Universite;
use Illuminate\Http\Request;

class AdminUniversiteController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_id')) return redirect()->route('admin.login');
        return null;
    }

    public function index(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;
        $query = Universite::withCount('campus');

        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        $universites = $query->latest()->paginate(15);
        return view('admin.universites.index', compact('universites'));
    }

    public function create()
    {
        if ($r = $this->checkAuth()) return $r;
        return view('admin.universites.create');
    }

    public function store(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        $request->validate([
            'nom'   => 'required|string|max:200',
            'sigle' => 'required|string|max:30',
            'ville' => 'required|string|max:100',
            'type'  => 'required|in:public,prive',
        ]);

        Universite::create([
            'nom'      => $request->nom,
            'sigle'    => $request->sigle,
            'ville'    => $request->ville,
            'type'     => $request->type,
            'latitude' => null,
            'longitude'=> null,
            'id_annee' => 1,
        ]);

        return redirect()->route('admin.universites')
                         ->with('success', 'Université ajoutée !');
    }

    public function edit($id)
    {
        if ($r = $this->checkAuth()) return $r;
        $universite = Universite::findOrFail($id);
        return view('admin.universites.edit', compact('universite'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->checkAuth()) return $r;

        $request->validate([
            'nom'   => 'required|string|max:200',
            'sigle' => 'required|string|max:30',
            'ville' => 'required|string|max:100',
            'type'  => 'required|in:public,prive',
            'statut' => 'required|in:en_attente,validee,rejetee',
        ]);

        $universite = Universite::findOrFail($id);
        $universite->update($request->only(['nom', 'sigle', 'ville', 'type', 'statut']));

        return redirect()->route('admin.universites')
                         ->with('success', 'Université mise à jour !');
    }

    public function destroy($id)
    {
        if ($r = $this->checkAuth()) return $r;
        Universite::findOrFail($id)->delete();
        return back()->with('success', 'Université supprimée.');
    }
}