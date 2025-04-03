<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('responsable_civil_contrats', function (Blueprint $table) {
            $table->id();
            $table->string('compagnie_assurance'); // Nom de la compagnie
            $table->string('ref_contrat')->unique(); // Référence unique du contrat
            $table->date('date_effet'); // Date d'effet du contrat
            $table->date('echeance'); // Date d'échéance
            $table->string('condition_renouvellement'); // Conditions de renouvellement
            $table->boolean('avenant')->default(false); // Avenant (oui/non)
            $table->string('objet_avenant'); // Conditions de renouvellement
            $table->string('attachement_contrat')->nullable(); // Fichier attaché (contrat)
            $table->string('attachement_avenant')->nullable(); // Fichier attaché (avenant)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('responsable_civil_contrats');
    }
};
