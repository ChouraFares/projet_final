<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('assurance_retraite_contracts', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('compagnie_assurance'); // Nom de la compagnie d'assurance
            $table->string('ref_contrat')->unique(); // Référence unique du contrat
            $table->date('date_effet'); // Date d'effet
            $table->date('echeance'); // Échéance
            $table->text('condition_renouvellement'); // Conditions de renouvellement
            $table->boolean('avenant')->default(false); // Avenant (oui/non)
            $table->string('objet_avenant')->nullable(); // Objet de l'avenant
            $table->string('attachement_contrat')->nullable(); // Attachement du contrat
            $table->string('attachement_avenant')->nullable(); // Attachement de l'avenant
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('assurance_retraite_contrats');
    }
};
