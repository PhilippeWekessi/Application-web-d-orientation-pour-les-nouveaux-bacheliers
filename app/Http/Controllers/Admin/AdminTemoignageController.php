<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Temoignage;

class AdminTemoignageController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_id')) return redirect()->route('admin.login');
        return null;
    }

    public function index()
    {
        if ($r = $this->checkAuth()) return $r;
        $temoignages = Temoignage::with(['user', 'filiere'])->latest()->paginate(15);
        return view('admin.temoignages.index', compact('temoignages'));
    }

    public function valider($id)
    {
        if ($r = $this->checkAuth()) return $r;
        Temoignage::findOrFail($id)->update(['statut' => 'valide']);
        return back()->with('success', 'Témoignage validé !');
    }

    public function rejeter($id)
    {
        if ($r = $this->checkAuth()) return $r;
        Temoignage::findOrFail($id)->update(['statut' => 'rejete']);
        return back()->with('success', 'Témoignage rejeté.');
    }
}