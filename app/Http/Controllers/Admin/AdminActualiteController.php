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

        // Validation manuelle
        $titre = trim($request->input('titre', ''));
        $contenu = trim($request->input('contenu', ''));

        $errors = [];
        if (empty($titre) || strlen($titre) > 200) {
            $errors['titre'] = 'Le titre est requis (max 200 caractères).';
        }
        if (empty($contenu)) {
            $errors['contenu'] = 'Le contenu est requis.';
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        Actualite::create([
            'titre'    => $titre,
            'contenu'  => $contenu,
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