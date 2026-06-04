<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use App\Models\Universite;
use App\Models\Filiere;
use App\Models\Campus;
use App\Models\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ResponsableDashboardController extends Controller
{
    private function checkAuth()
    {
        if (!session()->has('responsable_id')) {
            return redirect()->route('responsable.login')->send();
        }
        return null;
    }

    public function dashboard()
    {
        if ($r = $this->checkAuth()) return $r;

        $idResponsable = session('responsable_id');
        $universite = Universite::where('id_responsable_soumis', $idResponsable)->first();

        $filieres = collect(); 
        $campusList = collect();
        $filiersValidees = 0;
        $filiersEnAttente = 0;
        $filiersRejetees = 0;

        if ($universite && $universite->statut === 'validee') {
            $campusList = Campus::where('id_universite', $universite->id_universite)->get();
            
            $filieres = Filiere::whereIn('id_filiere', function($query) use ($universite) {
                $query->select('id_filiere')
                      ->from('uni_filieres')
                      ->whereIn('id_campus', function($q) use ($universite) {
                          $q->select('id_campus')
                            ->from('campus')
                            ->where('id_universite', $universite->id_universite);
                      });
            })->get();

            $filiersValidees = $filieres->where('statut', 'validee')->count();
            $filiersEnAttente = $filieres->where('statut', 'en_attente')->count();
            $filiersRejetees = $filieres->where('statut', 'rejetee')->count();
        }

        return view('responsable.dashboard', compact(
            'universite', 
            'filieres', 
            'campusList',
            'filiersValidees', 
            'filiersEnAttente', 
            'filiersRejetees'
        ));
    }

    public function createUniversite()
    {
        if ($r = $this->checkAuth()) return $r;
        return view('responsable.universite-create');
    }

    public function storeUniversite(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        // Validation manuelle
        $nom = trim($request->input('nom', ''));
        $sigle = trim($request->input('sigle', ''));
        $ville = trim($request->input('ville', ''));

        $errors = [];
        if (empty($nom) || strlen($nom) > 200) {
            $errors['nom'] = 'Le nom est requis (max 200 caractères).';
        }
        if (!empty($sigle) && strlen($sigle) > 30) {
            $errors['sigle'] = 'Le sigle ne doit pas dépasser 30 caractères.';
        }
        if (empty($ville) || strlen($ville) > 100) {
            $errors['ville'] = 'La ville est requise (max 100 caractères).';
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        Universite::create([
            'nom'                   => $nom,
            'sigle'                 => $sigle ?: '',
            'ville'                 => $ville,
            'type'                  => 'prive',
            'statut'                => 'en_attente',
            'id_annee'              => 1,
            'id_responsable_soumis' => session('responsable_id'),
        ]);

        return redirect()->route('responsable.dashboard')->with('success', 'Université soumise !');
    }

    public function createFiliere()
    {
        if ($r = $this->checkAuth()) return $r;

        $universite = Universite::where('id_responsable_soumis', session('responsable_id'))
                        ->where('statut', 'validee')
                        ->first();

        if (!$universite) {
            return redirect()->route('responsable.dashboard')
                             ->with('error', 'Votre université doit être validée.');
        }

        $campusList = Campus::where('id_universite', $universite->id_universite)->get();

        // Si aucun campus n'existe, en créer un automatiquement
        if ($campusList->isEmpty()) {
            Campus::create([
                'nom'           => $universite->nom . ' - Campus Principal',
                'adresse'       => 'À spécifier',
                'ville'         => $universite->ville,
                'id_universite' => $universite->id_universite,
            ]);
            $campusList = Campus::where('id_universite', $universite->id_universite)->get();
        }

        return view('responsable.filiere-create', compact('universite', 'campusList'));
    }

    public function storeFiliere(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        // Validation manuelle
        $nom = trim($request->input('nom', ''));
        $description = trim($request->input('description', ''));
        $duree_annees = $request->input('duree_annees');
        $mode_entree = trim($request->input('mode_entree', ''));
        $quota_bourse = $request->input('quota_bourse');
        $quota_aide_fpp = $request->input('quota_aide_fpp');
        $id_campus = $request->input('id_campus');

        $errors = [];
        if (empty($nom) || strlen($nom) > 255) {
            $errors['nom'] = 'Le nom est requis (max 255 caractères).';
        }
        if (empty($duree_annees) || !is_numeric($duree_annees) || $duree_annees < 1) {
            $errors['duree_annees'] = 'La durée doit être un nombre égal ou supérieur à 1.';
        }
        if (empty($mode_entree)) {
            $errors['mode_entree'] = 'Le mode d\'entrée est requis.';
        }
        if (!empty($quota_bourse) && !is_numeric($quota_bourse)) {
            $errors['quota_bourse'] = 'Le quota bourse doit être un nombre.';
        }
        if (!empty($quota_aide_fpp) && !is_numeric($quota_aide_fpp)) {
            $errors['quota_aide_fpp'] = 'Le quota aide FPP doit être un nombre.';
        }
        if (empty($id_campus)) {
            $errors['id_campus'] = 'Le campus est requis.';
        } else {
            $campus = Campus::where('id_campus', $id_campus)->first();
            if (!$campus) {
                $errors['id_campus'] = 'Le campus sélectionné est invalide.';
            }
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        $universite = Universite::where('id_responsable_soumis', session('responsable_id'))
                        ->where('statut', 'validee')
                        ->first();

        if (!$universite) {
            return redirect()->route('responsable.dashboard')
                             ->with('error', 'Votre université doit être validée.');
        }

        $campus = Campus::where('id_universite', $universite->id_universite)
                        ->where('id_campus', $id_campus)
                        ->first();

        if (!$campus) {
            return back()->with('error', 'Erreur : Le campus sélectionné n\'appartient pas à votre université.');
        }

        // 2. Création de la filière avec tous les champs
        $filiere = Filiere::create([
            'nom'            => $nom,
            'description'    => $description,
            'duree_annees'   => (int)$duree_annees,
            'mode_entree'    => $mode_entree,
            'quota_bourse'   => $quota_bourse ? (int)$quota_bourse : 0,
            'quota_aide_fpp' => $quota_aide_fpp ? (int)$quota_aide_fpp : 0,
            'statut'         => 'en_attente',
            'id_campus'      => $campus->id_campus,
            'id_universite_soumis' => session('responsable_id'),
        ]);

        // 3. Liaison dans la table pivot (UNI_FILIERES)
        // C'est cette étape qui permet l'affichage dans ton dashboard
        DB::table('uni_filieres')->insert([
            'id_filiere'      => $filiere->id_filiere,
            'id_campus'       => $campus->id_campus,
            'id_annee'        => 1,
            'quota_bourse'    => $quota_bourse ? (int)$quota_bourse : 0,
        ]);

        return redirect()->route('responsable.dashboard')
                         ->with('success', '🎉 Filière créée avec succès ! Elle est maintenant en attente de validation par l\'administrateur.');

    }

    public function profil()
    {
        if ($r = $this->checkAuth()) return $r;
        return view('responsable.profil');
    }

    public function updateProfil(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        // Validation manuelle
        $prenom = trim($request->input('prenom', ''));
        $nom = trim($request->input('nom', ''));

        $errors = [];
        if (empty($prenom) || strlen($prenom) > 255) {
            $errors['prenom'] = 'Le prénom est requis (max 255 caractères).';
        }
        if (empty($nom) || strlen($nom) > 255) {
            $errors['nom'] = 'Le nom est requis (max 255 caractères).';
        }

        // Vérifier la photo si fournie
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $mimeType = $file->getMimeType();
            if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
                $errors['photo'] = 'Le fichier doit être une image (JPEG, PNG, GIF).';
            }
            if ($file->getSize() > 2048000) {  // 2MB
                $errors['photo'] = 'L\'image ne doit pas dépasser 2MB.';
            }
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        try {
            $responsable = Responsable::find(session('responsable_id'));

            if (!$responsable) {
                return redirect()->route('responsable.profil')->with('error', 'Responsable non trouvé.');
            }

            // Gestion de la photo
            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($responsable->photo && Storage::disk('public')->exists($responsable->photo)) {
                    Storage::disk('public')->delete($responsable->photo);
                }

                // Sauvegarder la nouvelle photo
                $photoPath = $request->file('photo')->store('uploads', 'public');
                $responsable->photo = $photoPath;
            }

            // Mettre à jour les informations
            $responsable->prenom = $prenom;
            $responsable->nom = $nom;
            $responsable->save();

            // Mettre à jour la session
            session([
                'responsable_nom' => $responsable->nom,
                'responsable_prenom' => $responsable->prenom,
                'responsable_photo' => $responsable->photo,
            ]);

            return redirect()->route('responsable.profil')->with('success', 'Profil mis à jour avec succès.');

        } catch (\Exception $e) {
            return redirect()->route('responsable.profil')->with('error', 'Erreur lors de la mise à jour du profil.');
        }
    }
}