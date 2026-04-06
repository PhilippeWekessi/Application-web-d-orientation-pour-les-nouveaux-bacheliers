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
        Schema::create('campus', function (Blueprint $table) {
            $table->id('id_campus');
            $table->string('nom', 200);
            $table->text('adresse')->nullable();
            $table->string('ville', 100);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->unsignedBigInteger('id_universite');
            $table->foreign('id_universite')->references('id_universite')->on('universites')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campus');
    }
};
