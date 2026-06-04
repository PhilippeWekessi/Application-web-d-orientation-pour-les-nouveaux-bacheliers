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
        Schema::create('universites', function (Blueprint $table) {
            $table->id('id_universite');
            $table->string('nom', 200);
            $table->string('sigle', 30);
            $table->string('ville', 100);
            $table->enum('type', ['public', 'prive']);
            $table->enum('statut', ['en_attente', 'validee', 'rejetee'])->default('validee');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->unsignedBigInteger('id_annee');
            $table->foreign('id_annee')->references('id_annee')->on('annees')->cascadeOnDelete();
            $table->timestamps();
            $table->unsignedBigInteger('id_responsable_soumis')->nullable();
            $table->foreign('id_responsable_soumis')->references('id_responsable')->on('responsables')->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universites');
    }
};
