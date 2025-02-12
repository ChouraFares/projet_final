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
        Schema::create('mrd_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('compagnie_assurance');
            $table->string('ref_contrat');
            $table->date('date_effet');
            $table->date('echeance');
            $table->string('condition_renouvellement');
            $table->enum('avenant', ['oui', 'non']);
            $table->string('objet_avenant')->nullable();
            $table->string('attachement_contrat')->nullable(); // pour fichier PDF
            $table->string('attachement_avenant')->nullable(); // pour fichier PDF
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrd_contracts');
    }
};
