<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use Illuminate\Http\Request;

class ActualiteController extends Controller
{
    public function index()
    {
        $actualites = Actualite::orderBy('created_at', 'desc')->paginate(6);
        return view('actualites.index', compact('actualites'));
    }

    public function show($id)
    {
        $actualite = Actualite::findOrFail($id);
        return view('actualites.show', compact('actualite'));
    }

    public function subscribe(Request $request, $id)
    {
        $actualite = Actualite::findOrFail($id);
        $user = auth()->user();

        // Check if already subscribed
        if ($user->abonnements()->where('id_actualite', $id)->exists()) {
            // Unsubscribe
            $user->abonnements()->detach($id);
            return back()->with('success', 'Vous vous êtes désabonné de cette actualité.');
        } else {
            // Subscribe
            $user->abonnements()->attach($id, ['date_abonnement' => now()]);
            return back()->with('success', 'Vous êtes maintenant abonné à cette actualité.');
        }
    }
}