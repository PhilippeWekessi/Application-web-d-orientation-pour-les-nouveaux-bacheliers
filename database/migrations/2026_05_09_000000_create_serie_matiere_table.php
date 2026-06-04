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
        Schema::create('serie_matiere', function (Blueprint $table) {
            $table->unsignedBigInteger('id_serie');
            $table->unsignedBigInteger('id_matiere');
            $table->integer('coefficient');
            $table->primary(['id_serie', 'id_matiere']);
            $table->foreign('id_serie')->references('id_serie')->on('series')->cascadeOnDelete();
            $table->foreign('id_matiere')->references('id_matiere')->on('matieres')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serie_matiere');
    }
};
