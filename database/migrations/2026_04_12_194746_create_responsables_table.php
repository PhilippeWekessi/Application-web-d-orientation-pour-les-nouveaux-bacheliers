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
        Schema::create('responsables', function (Blueprint $table) {
            $table->id('id_responsable');
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->string('telephone', 20)->nullable();
            $table->string('fonction', 100)->nullable();
            $table->unsignedBigInteger('id_universite')->nullable();
            $table->enum('statut', ['actif', 'inactif', 'en_attente'])->default('en_attente');
            $table->foreign('id_universite')->references('id_universite')->on('universites')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsables');
    }
};
