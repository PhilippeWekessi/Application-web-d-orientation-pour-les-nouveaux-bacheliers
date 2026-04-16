<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // On crée la table et on ajoute tous les champs d'un coup
        Schema::create('filieres', function (Blueprint $table) {
            $table->id('id_filiere');
            $table->string('nom', 200);
            $table->text('description')->nullable();
            $table->tinyInteger('duree_annees');
            $table->enum('mode_entree', ['classement', 'concours', 'dossier', 'direct']);
            $table->integer('quota_bourse')->default(0);
            $table->integer('quota_aide_fpp')->default(0);
            
            // Ajout des champs que tu avais mis dans le deuxième bloc up()
            $table->enum('statut', ['en_attente', 'validee', 'rejetee'])->default('validee');
            $table->text('motif_rejet')->nullable();
            $table->unsignedBigInteger('id_universite_soumis')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filieres');
    }
};