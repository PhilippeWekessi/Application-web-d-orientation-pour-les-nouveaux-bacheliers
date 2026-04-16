<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Interet;
use App\Models\Filiere;
use App\Models\FiliereSerieMatiere;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $series  = Serie::orderBy('code')->get();
        $interets = Interet::orderBy('libelle')->get();

        // Matières par série (données statiques du guide MESRS)
        $matieresSerie = [
            'A1' => [
                ['nom' => 'Français',           'coef' => 5],
                ['nom' => 'Histoire-Géographie','coef' => 3],
                ['nom' => 'Anglais (LV1)',       'coef' => 3],
            ],
            'A2' => [
                ['nom' => 'Français',           'coef' => 5],
                ['nom' => 'Histoire-Géographie','coef' => 3],
                ['nom' => 'Anglais (LV1)',       'coef' => 3],
            ],
            'B' => [
                ['nom' => 'Français',  'coef' => 4],
                ['nom' => 'Économie',  'coef' => 5],
                ['nom' => 'Anglais',   'coef' => 3],
            ],
            'C' => [
                ['nom' => 'Mathématiques', 'coef' => 6],
                ['nom' => 'PCT',           'coef' => 5],
                ['nom' => 'Français',      'coef' => 3],
            ],
            'D' => [
                ['nom' => 'SVT',           'coef' => 5],
                ['nom' => 'PCT',           'coef' => 4],
                ['nom' => 'Mathématiques', 'coef' => 4],
            ],
            'E' => [
                ['nom' => 'Mathématiques', 'coef' => 6],
                ['nom' => 'PCT',           'coef' => 5],
                ['nom' => 'Français',      'coef' => 3],
            ],
            'G1' => [
                ['nom' => 'Français',           'coef' => 5],
                ['nom' => 'Histoire-Géographie','coef' => 4],
                ['nom' => 'Philosophie',         'coef' => 3],
            ],
            'G2' => [
                ['nom' => 'Mathématiques', 'coef' => 5],
                ['nom' => 'Étude de cas',  'coef' => 4],
                ['nom' => 'Français',      'coef' => 3],
            ],
            'G3' => [
                ['nom' => 'Mathématiques', 'coef' => 4],
                ['nom' => 'Étude de cas',  'coef' => 5],
                ['nom' => 'Français',      'coef' => 3],
            ],
        ];

        return view('questionnaire', compact('series', 'interets', 'matieresSerie'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'serie'   => 'required|string',
            'mention' => 'required|string',
            'moyenne' => 'required|numeric|min:10|max:20',
            'score'   => 'required|numeric',
        ]);

        // Stocker dans la session
        session([
            'questionnaire' => [
                'serie'    => $request->serie,
                'mention'  => $request->mention,
                'moyenne'  => $request->moyenne,
                'score'    => $request->score,
                'interets' => json_decode($request->interets, true) ?? [],
                'notes'    => json_decode($request->notes, true) ?? [],
                'ambition' => $request->ambition,
            ]
        ]);

        return redirect()->route('resultats');
    }
}