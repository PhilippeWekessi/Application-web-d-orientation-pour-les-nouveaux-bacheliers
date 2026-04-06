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
        Schema::create('recommandation_matieres', function (Blueprint $table) {
            $table->unsignedBigInteger('id_recommandation');
            $table->unsignedBigInteger('id_matiere');
            $table->decimal('note', 4, 2);
            $table->integer('coefficient');
            $table->primary(['id_recommandation', 'id_matiere']);
            $table->foreign('id_recommandation')->references('id_recommandation')->on('recommandations')->cascadeOnDelete();
            $table->foreign('id_matiere')->references('id_matiere')->on('matieres')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommandation_matieres');
    }
};
