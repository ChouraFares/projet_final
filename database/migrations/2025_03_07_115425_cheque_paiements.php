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
        Schema::create('cheque_paiements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('facture_id'); // Clé étrangère
            $table->string('payment_type', 100); // Limite de 100 caractères pour éviter de surcharger
            $table->decimal('montant', 15, 2)->nullable(); // Augmentation de la précision
            $table->string('ref_mdp', 255)->nullable();
            $table->date('date_expiration_assurance')->nullable();
            $table->string('numero_aliment_assurance')->nullable();
            $table->date('echeance_timbrage')->nullable();
            $table->string('timbrage_montant_retenue_a_la_source')->nullable();
            $table->enum('Etat', ['virement', 'chèque', 'traité'])->nullable();
            $table->string('Attachement_Timbrage')->nullable();
            $table->date('date_emission')->nullable(); // Ajout de la date d'émission du chèque
            $table->enum('statut', ['en_attente', 'encaissé', 'rejeté'])->default('en_attente'); // Ajout du statut du chèque

            $table->timestamps();
    
            // Clé étrangère avec suppression en cascade
            $table->foreign('facture_id')->references('id')->on('facture_complimentaire_thon')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cheque_paiements');
    }
};
