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
        Schema::create('temoignages', function (Blueprint $table) {
            $table->id('id_temoignage');
            $table->text('contenu');
            $table->tinyInteger('note');
            $table->enum('statut', ['en_attente', 'valide', 'rejete'])->default('en_attente');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_filiere');
            $table->foreign('id_user')->references('id_user')->on('users')->cascadeOnDelete();
            $table->foreign('id_filiere')->references('id_filiere')->on('filieres')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temoignages');
    }
};
