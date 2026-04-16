<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use Illuminate\Http\Request;

class AdminActualiteController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_id')) return redirect()->route('admin.login');
        return null;
    }

    public function index()
    {
        if ($r = $this->checkAuth()) return $r;
        $actualites = Actualite::latest()->paginate(10);
        return view('admin.actualites.index', compact('actualites'));
    }

    public function create()
    {
        if ($r = $this->checkAuth()) return $r;
        return view('admin.actualites.create');
    }

    public function store(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        $request->validate([
            'titre'   => 'required|string|max:200',
            'contenu' => 'required|string',
        ]);

        Actualite::create([
            'titre'    => $request->titre,
            'contenu'  => $request->contenu,
            'image'    => null,
            'id_admin' => session('admin_id'),
        ]);

        return redirect()->route('admin.actualites')
                         ->with('success', 'Actualité publiée avec succès !');
    }

    public function destroy($id)
    {
        if ($r = $this->checkAuth()) return $r;
        Actualite::findOrFail($id)->delete();
        return back()->with('success', 'Actualité supprimée.');
    }
}