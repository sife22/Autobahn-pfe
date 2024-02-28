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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date_depart');
            $table->date('date_retour');
            $table->integer('duree');
            $table->integer('montant');
            $table->unsignedBigInteger('client_id');
            $table->string('voiture_matricule', 10);
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('voiture_matricule')->references('matricule')->on('voitures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
