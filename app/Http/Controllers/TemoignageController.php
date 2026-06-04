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

    public function create()
    {
        $filieres = Filiere::orderBy('nom')->get();
        $series = Serie::orderBy('code')->get();
        return view('temoignages.create', compact('filieres', 'series'));
    }

    public function store(Request $request)
    {
        // Validation manuelle
        $id_filiere = $request->input('id_filiere');
        $note = $request->input('note');
        $contenu = trim($request->input('contenu', ''));

        $errors = [];
        if (empty($id_filiere)) {
            $errors['id_filiere'] = 'La filière est requise.';
        } else {
            $filiere = \App\Models\Filiere::where('id_filiere', $id_filiere)->first();
            if (!$filiere) {
                $errors['id_filiere'] = 'La filière sélectionnée est invalide.';
            }
        }
        if (empty($note) || !is_numeric($note) || $note < 1 || $note > 5 || $note != intval($note)) {
            $errors['note'] = 'La note doit être un nombre entier entre 1 et 5.';
        }
        if (empty($contenu) || strlen($contenu) < 20) {
            $errors['contenu'] = 'Le contenu doit contenir au moins 20 caractères.';
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        if (! session('user_id')) {
            return redirect()->route('login')
                             ->with('error', 'Vous devez être connecté pour soumettre un témoignage.');
        }

        Temoignage::create([
            'contenu'    => $contenu,
            'note'       => (int)$note,
            'statut'     => 'en_attente',
            'id_filiere' => $id_filiere,
            'id_user'    => session('user_id'),
        ]);

        return redirect()->route('temoignages.index')
                         ->with('success', 'Merci ! Ton témoignage a été soumis et sera publié après vérification.');
    }
}