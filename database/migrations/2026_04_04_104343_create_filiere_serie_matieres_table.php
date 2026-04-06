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
        Schema::create('filiere_serie_matieres', function (Blueprint $table) {
            $table->unsignedBigInteger('id_filiere');
            $table->unsignedBigInteger('id_serie');
            $table->unsignedBigInteger('id_matiere');
            $table->integer('coefficient');
            $table->primary(['id_filiere', 'id_serie', 'id_matiere'], 'fsm_primary');
            $table->foreign('id_filiere')->references('id_filiere')->on('filieres')->cascadeOnDelete();
            $table->foreign('id_serie')->references('id_serie')->on('series')->cascadeOnDelete();
            $table->foreign('id_matiere')->references('id_matiere')->on('matieres')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filiere_serie_matieres');
    }
};
