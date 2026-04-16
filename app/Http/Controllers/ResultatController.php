<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Serie;
use App\Models\UniFiliere;
use Illuminate\Http\Request;

class ResultatController extends Controller
{
    public function index()
    {
        $questionnaire = session('questionnaire');

        if (!$questionnaire) {
            return redirect()->route('questionnaire')
                             ->with('error', 'Veuillez d\'abord remplir le questionnaire.');
        }

        $serieCode = $questionnaire['serie'];
        $notes     = $questionnaire['notes'] ?? [];
        $interets  = $questionnaire['interets'] ?? [];

        // Trouver la série
        $serie = Serie::where('code', $serieCode)->first();

        // Matières et coefficients par série (formule officielle MESRS)
        $matieresSerie = [
            'A1' => [['coef' => 5], ['coef' => 3], ['coef' => 3]],
            'A2' => [['coef' => 5], ['coef' => 3], ['coef' => 3]],
            'B'  => [['coef' => 4], ['coef' => 5], ['coef' => 3]],
            'C'  => [['coef' => 6], ['coef' => 5], ['coef' => 3]],
            'D'  => [['coef' => 5], ['coef' => 4], ['coef' => 4]],
            'E'  => [['coef' => 6], ['coef' => 5], ['coef' => 3]],
            'F1' => [['coef' => 5], ['coef' => 4], ['coef' => 3]],
            'F2' => [['coef' => 5], ['coef' => 4], ['coef' => 3]],
            'F3' => [['coef' => 5], ['coef' => 4], ['coef' => 3]],
            'F4' => [['coef' => 5], ['coef' => 4], ['coef' => 3]],
            'G1' => [['coef' => 5], ['coef' => 4], ['coef' => 3]],
            'G2' => [['coef' => 5], ['coef' => 4], ['coef' => 3]],
            'G3' => [['coef' => 4], ['coef' => 5], ['coef' => 3]],
        ];

        // ===== CALCUL OFFICIEL MESRS =====
        // M = (m1×coef1 + m2×coef2 + m3×coef3) / (coef1 + coef2 + coef3)
        $coefs      = $matieresSerie[$serieCode] ?? [['coef'=>1],['coef'=>1],['coef'=>1]];
        $totalCoef  = array_sum(array_column($coefs, 'coef'));
        $somme      = 0;

        foreach ($notes as $i => $note) {
            $coef   = $coefs[$i]['coef'] ?? 1;
            $somme += floatval($note) * $coef;
        }

        // Moyenne de classement officielle
        $moyenneClassement = $totalCoef > 0 ? round($somme / $totalCoef, 2) : 0;

        // Mettre à jour le score dans la session avec la vraie moyenne
        $questionnaire['score'] = $moyenneClassement;
        session(['questionnaire' => $questionnaire]);

        // Récupérer les filières compatibles avec la série
        $filieres = Filiere::with(['campus.universite', 'series', 'interets'])
            ->whereHas('series', function($q) use ($serieCode) {
                $q->where('code', $serieCode);
            })
            ->get();

        // Si pas de filières pour cette série, prendre toutes
        if ($filieres->isEmpty()) {
            $filieres = Filiere::with(['campus.universite', 'series', 'interets'])->get();
        }

        $resultats = [];

        foreach ($filieres as $filiere) {

            // Récupérer le seuil bourse depuis uni_filieres
            $uniFiliere = UniFiliere::where('id_filiere', $filiere->id_filiere)
                            ->first();

            $seuilBourse = floatval($uniFiliere?->seuil_bourse ?? 12.00);

            // Règle officielle MESRS :
            // Boursier  : M >= seuil_bourse
            // FPP       : M >= seuil_bourse - 1.5
            // Non admis : M < seuil_bourse - 1.5
            $seuilFpp = $seuilBourse - 1.5;

            if ($moyenneClassement >= $seuilBourse) {
                $diagnostic = 'boursier';
            } elseif ($moyenneClassement >= $seuilFpp) {
                $diagnostic = 'fpp';
            } else {
                $diagnostic = 'non_admissible';
            }

            // Vérifier si la filière correspond aux intérêts du bachelier
            $correspondInteret = false;
            if (!empty($interets)) {
                $filiereInterets = $filiere->interets->pluck('id_interet')->map(fn($i) => (string)$i)->toArray();
                foreach ($interets as $interet) {
                    if (in_array((string)$interet, $filiereInterets)) {
                        $correspondInteret = true;
                        break;
                    }
                }
            }

            $resultats[] = [
                'filiere'           => $filiere,
                'moyenne'           => $moyenneClassement,
                'diagnostic'        => $diagnostic,
                'seuil_bourse'      => $seuilBourse,
                'seuil_fpp'         => $seuilFpp,
                'correspond_interet'=> $correspondInteret,
                'quota_bourse'      => $uniFiliere?->quota_bourse ?? $filiere->quota_bourse,
                'quota_fpp'         => $filiere->quota_aide_fpp,
            ];
        }

        // ===== TRI OFFICIEL MESRS =====
        // 1. Boursier en premier (moyenne la plus haute)
        // 2. FPP ensuite
        // 3. Non admissible en dernier
        // À égalité de diagnostic : filières avec intérêts correspondants en premier
        usort($resultats, function($a, $b) {
            $ordre = ['boursier' => 0, 'fpp' => 1, 'non_admissible' => 2];

            // D'abord trier par diagnostic
            if ($ordre[$a['diagnostic']] !== $ordre[$b['diagnostic']]) {
                return $ordre[$a['diagnostic']] - $ordre[$b['diagnostic']];
            }

            // Ensuite les filières qui correspondent aux intérêts
            if ($a['correspond_interet'] !== $b['correspond_interet']) {
                return $b['correspond_interet'] - $a['correspond_interet'];
            }

            // Enfin par quota bourse décroissant
            return $b['quota_bourse'] - $a['quota_bourse'];
        });

        return view('resultats', compact('resultats', 'questionnaire'));
    }
}