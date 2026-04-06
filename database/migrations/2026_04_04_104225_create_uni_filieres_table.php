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
        Schema::create('uni_filieres', function (Blueprint $table) {
            $table->unsignedBigInteger('id_campus');
            $table->unsignedBigInteger('id_filiere');
            $table->unsignedBigInteger('id_annee');
            $table->integer('quota_bourse')->default(0);
            $table->decimal('seuil_bourse', 5, 2)->nullable();
            $table->primary(['id_campus', 'id_filiere']);
            $table->foreign('id_campus')->references('id_campus')->on('campus')->cascadeOnDelete();
            $table->foreign('id_filiere')->references('id_filiere')->on('filieres')->cascadeOnDelete();
            $table->foreign('id_annee')->references('id_annee')->on('annees')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uni_filieres');
    }
};
