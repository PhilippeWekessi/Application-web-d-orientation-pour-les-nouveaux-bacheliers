<?php

namespace App\Http\Controllers;

use App\Models\Temoignage;
use App\Models\Filiere;
use App\Models\Serie;
use App\Models\Universite;
use Illuminate\Http\Request;

class TemoignageController extends Controller
{
    public function index(Request $request)
    {
        $query = Temoignage::where('statut', 'valide')
                           ->with(['user.serie', 'filiere']);

        // Filtre par filière
        if ($request->filiere) {
            $query->where('id_filiere', $request->filiere);
        }

        // Filtre par note
        if ($request->note) {
            $query->where('note', $request->note);
        }

        $temoignages    = $query->orderBy('created_at', 'desc')->paginate(6);
        $filieres       = Filiere::orderBy('nom')->get();
        $series         = Serie::orderBy('code')->get();
        $totalTemoignages = Temoignage::where('statut', 'valide')->count();
        $moyenneNotes   = Temoignage::where('statut', 'valide')->avg('note') ?? 0;
        $totalFilieres  = Temoignage::where('statut', 'valide')->distinct('id_filiere')->count();
        $totalUniversites = Universite::count();

        return view('temoignages.index', compact(
            'temoignages', 'filieres', 'series',
            'totalTemoignages', 'moyenneNotes',
            'totalFilieres', 'totalUniversites'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_prenom'  => 'required|string|max:200',
            'id_filiere'  => 'required|exists:filieres,id_filiere',
            'note'        => 'required|integer|min:1|max:5',
            'contenu'     => 'required|string|min:20',
        ]);

        Temoignage::create([
            'contenu'    => $request->contenu,
            'note'       => $request->note,
            'statut'     => 'en_attente',
            'id_filiere' => $request->id_filiere,
            'id_user'    => 1, // temporaire, à remplacer par auth()->id()
        ]);

        return redirect()->route('temoignages.index')
                         ->with('success', 'Merci ! Ton témoignage a été soumis et sera publié après vérification.');
    }
}