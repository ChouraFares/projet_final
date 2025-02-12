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
        Schema::create('flotte_sinistres', function (Blueprint $table) {
            $table->id();
            $table->string('compagnie_assurance')->nullable();
            $table->string('sinistre_num')->nullable();
            $table->string('immatriculation')->nullable();
            $table->string('vehicule')->nullable();
            $table->string('chauffeur')->nullable();
            $table->enum('fautif', ['Oui', 'Non'])->nullable();
            $table->date('date_sinistre')->nullable();
            $table->string('nature_sinistre')->nullable();
            $table->string('situation_dossier')->nullable();
            $table->date('date_cloture_dossier')->nullable();
            $table->text('reglement')->nullable(); // Montant du règlement
            $table->string('Expert')->nullable(); // Expert en charge du dossier

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flotte_sinistres');
    }
};
