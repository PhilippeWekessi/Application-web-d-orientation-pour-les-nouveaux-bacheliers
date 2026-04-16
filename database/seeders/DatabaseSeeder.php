<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== ANNEE =====
        DB::table('annees')->insert([
            ['libelle' => '2024-2025', 'est_active' => true],
        ]);

        // ===== SERIES =====
        DB::table('series')->insert([
            ['code' => 'A1', 'libelle' => 'Lettres et Langues'],
            ['code' => 'A2', 'libelle' => 'Lettres et Sciences Humaines'],
            ['code' => 'B',  'libelle' => 'Lettres et Sciences Sociales'],
            ['code' => 'C',  'libelle' => 'Sciences et Techniques'],
            ['code' => 'D',  'libelle' => 'Biologie et Géologie'],
            ['code' => 'E',  'libelle' => 'Mathématiques et Techniques'],
            ['code' => 'F1', 'libelle' => 'Construction Mécanique'],
            ['code' => 'F2', 'libelle' => 'Électronique'],
            ['code' => 'F3', 'libelle' => 'Électrotechnique'],
            ['code' => 'F4', 'libelle' => 'Génie Civil'],
            ['code' => 'G1', 'libelle' => 'Techniques Administratives'],
            ['code' => 'G2', 'libelle' => 'Techniques Quantitatives'],
            ['code' => 'G3', 'libelle' => 'Techniques Commerciales'],
        ]);

        // ===== MATIERES =====
        DB::table('matieres')->insert([
            ['nom' => 'Mathématiques'],
            ['nom' => 'PCT (Physique-Chimie)'],
            ['nom' => 'SVT (Sciences de la Vie et de la Terre)'],
            ['nom' => 'Français'],
            ['nom' => 'Histoire-Géographie'],
            ['nom' => 'Anglais (LV1)'],
            ['nom' => 'Économie'],
            ['nom' => 'Philosophie'],
            ['nom' => 'Étude de cas'],
        ]);

        // ===== INTERETS =====
        DB::table('interets')->insert([
            ['libelle' => 'Informatique & Numérique',    'icone' => '💻'],
            ['libelle' => 'Santé & Médecine',            'icone' => '⚕️'],
            ['libelle' => 'Droit & Justice',             'icone' => '⚖️'],
            ['libelle' => 'Économie & Gestion',          'icone' => '📊'],
            ['libelle' => 'Agriculture & Environnement', 'icone' => '🌱'],
            ['libelle' => 'Ingénierie & BTP',            'icone' => '🏗️'],
            ['libelle' => 'Lettres & Sciences Humaines', 'icone' => '📚'],
            ['libelle' => 'Sciences & Recherche',        'icone' => '🔬'],
            ['libelle' => 'Arts & Culture',              'icone' => '🎨'],
        ]);

        // ===== UNIVERSITES =====
        DB::table('universites')->insert([
            ['nom' => 'Université d\'Abomey-Calavi', 'sigle' => 'UAC', 'ville' => 'Abomey-Calavi', 'type' => 'public', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_annee' => 1],
            ['nom' => 'Université de Parakou', 'sigle' => 'UP', 'ville' => 'Parakou', 'type' => 'public', 'latitude' => 9.3375, 'longitude' => 2.6276, 'id_annee' => 1],
            ['nom' => 'Université Nationale des Sciences, Technologies, Ingénierie et Mathématiques', 'sigle' => 'UNSTIM', 'ville' => 'Abomey', 'type' => 'public', 'latitude' => 7.1827, 'longitude' => 1.9912, 'id_annee' => 1],
            ['nom' => 'Université Nationale d\'Agriculture', 'sigle' => 'UNA', 'ville' => 'Kétou', 'type' => 'public', 'latitude' => 7.3578, 'longitude' => 2.6012, 'id_annee' => 1],
        ]);

        // ===== CAMPUS =====
        DB::table('campus')->insert([
            ['nom' => 'IFRI',   'adresse' => 'Campus UAC', 'ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
            ['nom' => 'FSS',    'adresse' => 'Campus UAC', 'ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
            ['nom' => 'FASEG',  'adresse' => 'Campus UAC', 'ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
            ['nom' => 'FADESP', 'adresse' => 'Campus UAC', 'ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
            ['nom' => 'FSA',    'adresse' => 'Campus UAC', 'ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
            ['nom' => 'EPAC',   'adresse' => 'Campus UAC', 'ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
            ['nom' => 'FAST',   'adresse' => 'Campus UAC', 'ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
            ['nom' => 'FLASH',  'adresse' => 'Campus UAC', 'ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
        ]);

        // ===== FILIERES =====
        DB::table('filieres')->insert([
            ['nom' => 'Génie Logiciel',                             'description' => 'Formation en développement logiciel',      'duree_annees' => 3, 'mode_entree' => 'classement', 'quota_bourse' => 20,  'quota_aide_fpp' => 30],
            ['nom' => 'Médecine Générale',                          'description' => 'Formation en médecine générale',           'duree_annees' => 7, 'mode_entree' => 'classement', 'quota_bourse' => 150, 'quota_aide_fpp' => 100],
            ['nom' => 'Sciences Économiques et de Gestion',         'description' => 'Économie et gestion des entreprises',      'duree_annees' => 3, 'mode_entree' => 'classement', 'quota_bourse' => 153, 'quota_aide_fpp' => 80],
            ['nom' => 'Intelligence Artificielle',                  'description' => 'Formation en IA et machine learning',      'duree_annees' => 3, 'mode_entree' => 'classement', 'quota_bourse' => 20,  'quota_aide_fpp' => 25],
            ['nom' => 'Droit Privé',                                'description' => 'Formation en droit privé',                 'duree_annees' => 3, 'mode_entree' => 'classement', 'quota_bourse' => 111, 'quota_aide_fpp' => 60],
            ['nom' => 'Sciences et Techniques de Production Végétale', 'description' => 'Agronomie végétale',                   'duree_annees' => 3, 'mode_entree' => 'classement', 'quota_bourse' => 16,  'quota_aide_fpp' => 20],
            ['nom' => 'Génie Civil',                                'description' => 'Formation en génie civil et BTP',          'duree_annees' => 3, 'mode_entree' => 'classement', 'quota_bourse' => 30,  'quota_aide_fpp' => 20],
            ['nom' => 'Pharmacie',                                  'description' => 'Formation en pharmacie',                   'duree_annees' => 6, 'mode_entree' => 'classement', 'quota_bourse' => 40,  'quota_aide_fpp' => 30],
        ]);

        // ===== LIEN CAMPUS-FILIERE =====
        DB::table('uni_filieres')->insert([
            ['id_campus' => 1, 'id_filiere' => 1, 'id_annee' => 1, 'quota_bourse' => 20,  'seuil_bourse' => 12.00],
            ['id_campus' => 2, 'id_filiere' => 2, 'id_annee' => 1, 'quota_bourse' => 150, 'seuil_bourse' => 14.00],
            ['id_campus' => 3, 'id_filiere' => 3, 'id_annee' => 1, 'quota_bourse' => 153, 'seuil_bourse' => 11.00],
            ['id_campus' => 1, 'id_filiere' => 4, 'id_annee' => 1, 'quota_bourse' => 20,  'seuil_bourse' => 12.00],
            ['id_campus' => 4, 'id_filiere' => 5, 'id_annee' => 1, 'quota_bourse' => 111, 'seuil_bourse' => 10.00],
            ['id_campus' => 5, 'id_filiere' => 6, 'id_annee' => 1, 'quota_bourse' => 16,  'seuil_bourse' => 12.00],
            ['id_campus' => 6, 'id_filiere' => 7, 'id_annee' => 1, 'quota_bourse' => 30,  'seuil_bourse' => 11.00],
            ['id_campus' => 2, 'id_filiere' => 8, 'id_annee' => 1, 'quota_bourse' => 40,  'seuil_bourse' => 14.00],
        ]);

        // ===== FILIERE-INTERET =====
        DB::table('filiere_interet')->insert([
            ['id_filiere' => 1, 'id_interet' => 1], // Génie Logiciel → Informatique
            ['id_filiere' => 4, 'id_interet' => 1], // IA → Informatique
            ['id_filiere' => 2, 'id_interet' => 2], // Médecine → Santé
            ['id_filiere' => 8, 'id_interet' => 2], // Pharmacie → Santé
            ['id_filiere' => 5, 'id_interet' => 3], // Droit → Droit
            ['id_filiere' => 3, 'id_interet' => 4], // SEG → Économie
            ['id_filiere' => 6, 'id_interet' => 5], // STPV → Agriculture
            ['id_filiere' => 7, 'id_interet' => 6], // Génie Civil → Ingénierie
            ['id_filiere' => 1, 'id_interet' => 8], // Génie Logiciel → Sciences
            ['id_filiere' => 4, 'id_interet' => 8], // IA → Sciences
        ]);

        // ===== FILIERE-SERIE-MATIERES (formule MESRS) =====
        // Série C (id=4) : Maths coef6, PCT coef5, Français coef3
        // Série D (id=5) : SVT coef5, PCT coef4, Maths coef4
        DB::table('filiere_serie_matieres')->insert([
            // Génie Logiciel
            ['id_filiere' => 1, 'id_serie' => 4, 'id_matiere' => 1, 'coefficient' => 6], // Série C - Maths
            ['id_filiere' => 1, 'id_serie' => 4, 'id_matiere' => 2, 'coefficient' => 5], // Série C - PCT
            ['id_filiere' => 1, 'id_serie' => 4, 'id_matiere' => 4, 'coefficient' => 3], // Série C - Français
            ['id_filiere' => 1, 'id_serie' => 5, 'id_matiere' => 3, 'coefficient' => 5], // Série D - SVT
            ['id_filiere' => 1, 'id_serie' => 5, 'id_matiere' => 2, 'coefficient' => 4], // Série D - PCT
            ['id_filiere' => 1, 'id_serie' => 5, 'id_matiere' => 1, 'coefficient' => 4], // Série D - Maths

            // Médecine Générale
            ['id_filiere' => 2, 'id_serie' => 4, 'id_matiere' => 2, 'coefficient' => 5], // Série C - PCT
            ['id_filiere' => 2, 'id_serie' => 4, 'id_matiere' => 1, 'coefficient' => 6], // Série C - Maths
            ['id_filiere' => 2, 'id_serie' => 4, 'id_matiere' => 4, 'coefficient' => 3], // Série C - Français
            ['id_filiere' => 2, 'id_serie' => 5, 'id_matiere' => 3, 'coefficient' => 5], // Série D - SVT
            ['id_filiere' => 2, 'id_serie' => 5, 'id_matiere' => 2, 'coefficient' => 4], // Série D - PCT
            ['id_filiere' => 2, 'id_serie' => 5, 'id_matiere' => 1, 'coefficient' => 4], // Série D - Maths

            // Sciences Économiques
            ['id_filiere' => 3, 'id_serie' => 4, 'id_matiere' => 1, 'coefficient' => 6], // Série C - Maths
            ['id_filiere' => 3, 'id_serie' => 4, 'id_matiere' => 2, 'coefficient' => 5], // Série C - PCT
            ['id_filiere' => 3, 'id_serie' => 4, 'id_matiere' => 4, 'coefficient' => 3], // Série C - Français
            ['id_filiere' => 3, 'id_serie' => 12, 'id_matiere' => 1, 'coefficient' => 5], // Série G2 - Maths
            ['id_filiere' => 3, 'id_serie' => 12, 'id_matiere' => 9, 'coefficient' => 4], // Série G2 - Étude de cas
            ['id_filiere' => 3, 'id_serie' => 12, 'id_matiere' => 4, 'coefficient' => 3], // Série G2 - Français

            // Droit Privé
            ['id_filiere' => 5, 'id_serie' => 1, 'id_matiere' => 4, 'coefficient' => 5], // Série A1 - Français
            ['id_filiere' => 5, 'id_serie' => 1, 'id_matiere' => 5, 'coefficient' => 3], // Série A1 - Hist-Géo
            ['id_filiere' => 5, 'id_serie' => 1, 'id_matiere' => 6, 'coefficient' => 3], // Série A1 - Anglais
            ['id_filiere' => 5, 'id_serie' => 2, 'id_matiere' => 4, 'coefficient' => 5], // Série A2 - Français
            ['id_filiere' => 5, 'id_serie' => 2, 'id_matiere' => 5, 'coefficient' => 3], // Série A2 - Hist-Géo
            ['id_filiere' => 5, 'id_serie' => 2, 'id_matiere' => 6, 'coefficient' => 3], // Série A2 - Anglais
        ]);

        // ===== DEBOUCHES =====
        DB::table('debouches')->insert([
            ['intitule' => 'Développeur Logiciel',    'secteur' => 'Informatique'],
            ['intitule' => 'Médecin Généraliste',     'secteur' => 'Santé'],
            ['intitule' => 'Économiste',              'secteur' => 'Finance'],
            ['intitule' => 'Juriste',                 'secteur' => 'Droit'],
            ['intitule' => 'Ingénieur Agronome',      'secteur' => 'Agriculture'],
            ['intitule' => 'Ingénieur Civil',         'secteur' => 'BTP'],
            ['intitule' => 'Data Scientist',          'secteur' => 'Informatique'],
            ['intitule' => 'Pharmacien',              'secteur' => 'Santé'],
        ]);

        // ===== FILIERE-DEBOUCHE =====
        DB::table('filiere_debouche')->insert([
            ['id_filiere' => 1, 'id_debouche' => 1],
            ['id_filiere' => 1, 'id_debouche' => 7],
            ['id_filiere' => 2, 'id_debouche' => 2],
            ['id_filiere' => 3, 'id_debouche' => 3],
            ['id_filiere' => 4, 'id_debouche' => 7],
            ['id_filiere' => 5, 'id_debouche' => 4],
            ['id_filiere' => 6, 'id_debouche' => 5],
            ['id_filiere' => 7, 'id_debouche' => 6],
            ['id_filiere' => 8, 'id_debouche' => 8],
        ]);

        
        // Admin
        DB::table('admins')->insert([
            'nom'      => 'MESRS',
            'prenom'   => 'Admin',
            'email'    => 'admin@orientabac.bj',
            'password' => Hash::make('admin123'),
        ]);
    }
}