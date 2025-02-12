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
        Schema::create('flotte_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('compagnie_assurance');
            $table->string('ref_contrat');
            $table->date('date_effet');
            $table->date('echeance');
            $table->string('condition_renouvellement');
            $table->boolean('avenant')->default(false);
            $table->string('objet_avenant')->nullable();
            $table->string('attachement_contrat')->nullable(); // URL ou chemin du fichier PDF
            $table->string('attachement_avenant')->nullable(); // URL ou chemin du fichier PDF pour l'avenant
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flotte_contracts');
    }
};
