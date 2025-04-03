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
        Schema::create('bris_de_machine_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('compagnie_assurance');
            $table->string('ref_contrat');
            $table->date('date_effet');
            $table->date('echeance');
            $table->text('condition_renouvellement')->nullable();
            $table->boolean('avenant')->default(false);
            $table->string('objet_avenant')->nullable();
            $table->string('attachement_contrat')->nullable();
            $table->string('attachement_avenant')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
