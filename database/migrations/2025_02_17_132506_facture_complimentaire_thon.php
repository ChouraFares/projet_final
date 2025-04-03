<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('facture_complimentaire_thon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('date_demande')->nullable(); // Remplacez default(DB::raw('CURRENT_TIMESTAMP')) par nullable()
            $table->string('facture', 255); // Ajout de l'unicité sur le numéro de facture
            $table->string('num_conteneur', 255)->nullable();
            $table->string('fournisseur', 255)->nullable();
            $table->string('armateur', 255)->nullable();
            $table->string('incoterm', 50)->nullable();
            $table->string('port', 255)->nullable();
            $table->string('bank', 255)->nullable();
            $table->date('date_declaration')->nullable();
            $table->string('assureur', 255)->nullable();
            $table->date('date_expiration')->nullable();
            $table->decimal('total', 15, 2)->nullable(); // Augmentation de la précision
            $table->string('BL', 255)->nullable();
    
            // Indicateurs de préparation des paiements
            $table->boolean('recette_finance_preparer_paiement')->default(false);
            $table->boolean('douane_preparer_paiement')->default(false);
            $table->boolean('timbrage_et_avances_surestarie_preparer_paiement')->default(false);
            $table->boolean('stam_preparer_paiement')->default(false);
            $table->boolean('assurance_preparer_paiement')->default(false);
    
            $table->date('date_recuperation')->nullable();
            $table->date('date_enlevement')->nullable();
    
            // Statuts de validation
            $table->enum('validation_transit', ['en_attente', 'Validé', 'Refusé', 'Validé par DG'])->default('en_attente');
            $table->enum('statut_finance', ['non_entame', 'encours_de_traitement', 'traite', 'mdp_en_cours_de_remise', 'cloture'])->default('non_entame');
            $table->enum('validation_finance', ['en_attente', 'Validé', 'Refusé'])->default('en_attente');
    
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('facture_complimentaire_thon');
    }
};
