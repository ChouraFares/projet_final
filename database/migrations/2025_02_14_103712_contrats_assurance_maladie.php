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
 

        Schema::create('contrats_assurance_maladie', function (Blueprint $table) {
            $table->id();
            $table->string('compagnie_assurance');
            $table->string('ref_contrat');
            $table->date('date_effet');
            $table->date('echeance');
            $table->string('condition_renouvellement');
            $table->string('avenant');
            $table->string('objet_avenant');
            $table->string('attachement_contrat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats_assurance_maladie');
    }
};
