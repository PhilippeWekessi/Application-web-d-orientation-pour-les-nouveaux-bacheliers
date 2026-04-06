<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Annee
        DB::table('annees')->insert([
            ['libelle' => '2024-2025', 'est_active' => true],
        ]);

        // Series
        DB::table('series')->insert([
            ['code' => 'A1', 'libelle' => 'Série A1 (Lettres-Langues)'],
            ['code' => 'A2', 'libelle' => 'Série A2 (Lettres-SH)'],
            ['code' => 'C',  'libelle' => 'Série C (Sciences)'],
            ['code' => 'D',  'libelle' => 'Série D (Bio-Géologie)'],
            ['code' => 'E',  'libelle' => 'Série E (Maths-Tech)'],
            ['code' => 'G1', 'libelle' => 'Série G1'],
            ['code' => 'G2', 'libelle' => 'Série G2'],
            ['code' => 'G3', 'libelle' => 'Série G3'],
        ]);

        // Universites
        DB::table('universites')->insert([
            ['nom' => 'Université d\'Abomey-Calavi', 'sigle' => 'UAC', 'ville' => 'Abomey-Calavi', 'type' => 'public', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_annee' => 1],
            ['nom' => 'Université de Parakou', 'sigle' => 'UP', 'ville' => 'Parakou', 'type' => 'public', 'latitude' => 9.3375, 'longitude' => 2.6276, 'id_annee' => 1],
            ['nom' => 'Université Nationale des Sciences, Technologies, Ingénierie et Mathématiques', 'sigle' => 'UNSTIM', 'ville' => 'Abomey', 'type' => 'public', 'latitude' => 7.1827, 'longitude' => 1.9912, 'id_annee' => 1],
        ]);

        // Campus
        DB::table('campus')->insert([
            ['nom' => 'IFRI', 'adresse' => 'Campus UAC', 'ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
            ['nom' => 'FSS',  'adresse' => 'Campus UAC', 'ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
            ['nom' => 'FASEG','adresse' => 'Campus UAC', 'ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
            ['nom' => 'FADESP','adresse' => 'Campus UAC','ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
            ['nom' => 'FSA',  'adresse' => 'Campus UAC', 'ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
            ['nom' => 'EPAC', 'adresse' => 'Campus UAC', 'ville' => 'Abomey-Calavi', 'latitude' => 6.4077, 'longitude' => 2.3419, 'id_universite' => 1],
        ]);

        // Filieres
        DB::table('filieres')->insert([
            ['nom' => 'Génie Logiciel',          'description' => 'Formation en développement logiciel',       'duree_annees' => 3, 'mode_entree' => 'classement', 'quota_bourse' => 20,  'quota_aide_fpp' => 30],
            ['nom' => 'Médecine Générale',        'description' => 'Formation en médecine générale',            'duree_annees' => 7, 'mode_entree' => 'classement', 'quota_bourse' => 150, 'quota_aide_fpp' => 100],
            ['nom' => 'Sciences Économiques et de Gestion', 'description' => 'Économie et gestion',            'duree_annees' => 3, 'mode_entree' => 'classement', 'quota_bourse' => 153, 'quota_aide_fpp' => 80],
            ['nom' => 'Intelligence Artificielle','description' => 'Formation en IA et machine learning',       'duree_annees' => 3, 'mode_entree' => 'classement', 'quota_bourse' => 20,  'quota_aide_fpp' => 25],
            ['nom' => 'Droit Privé',              'description' => 'Formation en droit privé',                 'duree_annees' => 3, 'mode_entree' => 'classement', 'quota_bourse' => 111, 'quota_aide_fpp' => 60],
            ['nom' => 'Sciences et Techniques de Production Végétale', 'description' => 'Agronomie végétale',  'duree_annees' => 3, 'mode_entree' => 'classement', 'quota_bourse' => 16,  'quota_aide_fpp' => 20],
        ]);

        // Lien Campus-Filiere (uni_filieres)
        DB::table('uni_filieres')->insert([
            ['id_campus' => 1, 'id_filiere' => 1, 'id_annee' => 1, 'quota_bourse' => 20,  'seuil_bourse' => 12.00],
            ['id_campus' => 2, 'id_filiere' => 2, 'id_annee' => 1, 'quota_bourse' => 150, 'seuil_bourse' => 14.00],
            ['id_campus' => 3, 'id_filiere' => 3, 'id_annee' => 1, 'quota_bourse' => 153, 'seuil_bourse' => 11.00],
            ['id_campus' => 1, 'id_filiere' => 4, 'id_annee' => 1, 'quota_bourse' => 20,  'seuil_bourse' => 12.00],
            ['id_campus' => 4, 'id_filiere' => 5, 'id_annee' => 1, 'quota_bourse' => 111, 'seuil_bourse' => 10.00],
            ['id_campus' => 5, 'id_filiere' => 6, 'id_annee' => 1, 'quota_bourse' => 16,  'seuil_bourse' => 12.00],
        ]);

        // Lien Filiere-Serie
        DB::table('filiere_serie_matieres')->insert([
            // Génie Logiciel → Série C, D, E
            ['id_filiere' => 1, 'id_serie' => 3, 'id_matiere' => 1, 'coefficient' => 5],
            ['id_filiere' => 1, 'id_serie' => 4, 'id_matiere' => 1, 'coefficient' => 4],
            // Médecine → Série C, D
            ['id_filiere' => 2, 'id_serie' => 3, 'id_matiere' => 1, 'coefficient' => 6],
            ['id_filiere' => 2, 'id_serie' => 4, 'id_matiere' => 1, 'coefficient' => 5],
        ]);
    }
}