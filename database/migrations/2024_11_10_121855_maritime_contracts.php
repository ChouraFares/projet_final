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
        Schema::create('maritime_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('compagnie_assurance'); // Compagnie d'assurance
            $table->string('ref_contrat'); // Réf contrat
            $table->date('date_effet'); // DATE D'EFFET
            $table->date('echeance'); // ECHEANCE
            $table->string('condition_renouvellement'); // CONDITION RENOUVEMENT
            $table->boolean('avenant')->default(false); // Avenant (oui/non)
            $table->string('objet_avenant')->nullable(); // Objet de l'avenant
            $table->string('attachement_contrat')->nullable(); // Attachement contrat (URL ou chemin du fichier PDF)
            $table->string('attachement_avenant')->nullable(); // Attachement avenant (URL ou chemin du fichier PDF)
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maritime_contracts');
    }
};
