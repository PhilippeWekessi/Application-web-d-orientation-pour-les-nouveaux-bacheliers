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
        Schema::table('universites', function (Blueprint $table) {
            $table->enum('statut', ['en_attente', 'validee', 'rejetee'])->default('validee');
            $table->text('motif_rejet')->nullable();
            $table->unsignedBigInteger('id_responsable_soumis')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('universites', function (Blueprint $table) {
            $table->dropColumn(['statut', 'motif_rejet', 'id_responsable_soumis']);
        });
    }
};