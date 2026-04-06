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
        Schema::create('filiere_debouche', function (Blueprint $table) {
            $table->unsignedBigInteger('id_filiere');
            $table->unsignedBigInteger('id_debouche');
            $table->primary(['id_filiere', 'id_debouche']);
            $table->foreign('id_filiere')->references('id_filiere')->on('filieres')->cascadeOnDelete();
            $table->foreign('id_debouche')->references('id_debouche')->on('debouches')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filiere_debouche');
    }
};
