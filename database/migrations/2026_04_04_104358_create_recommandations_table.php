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
        Schema::create('recommandations', function (Blueprint $table) {
            $table->id('id_recommandation');
            $table->decimal('score', 5, 2);
            $table->enum('diagnostic', ['boursier', 'fpp', 'non_admissible']);
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_filiere');
            $table->unsignedBigInteger('id_serie');
            $table->foreign('id_user')->references('id_user')->on('users')->cascadeOnDelete();
            $table->foreign('id_filiere')->references('id_filiere')->on('filieres')->cascadeOnDelete();
            $table->foreign('id_serie')->references('id_serie')->on('series')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommandations');
    }
};
