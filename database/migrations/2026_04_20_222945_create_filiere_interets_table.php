<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filiere_interets', function (Blueprint $table) {
            $table->unsignedBigInteger('id_filiere');
            $table->unsignedBigInteger('id_interet');
            $table->primary(['id_filiere', 'id_interet']);
            $table->foreign('id_filiere')
                  ->references('id_filiere')
                  ->on('filieres')
                  ->cascadeOnDelete();
            $table->foreign('id_interet')
                  ->references('id_interet')
                  ->on('interets')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filiere_interets');
    }
};