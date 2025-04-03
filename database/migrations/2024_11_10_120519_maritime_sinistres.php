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
        Schema::create('maritime_sinistres', function (Blueprint $table) {
            $table->id();
            $table->string('numero_sinistre')->unique();
            $table->string('assureur')->nullable();
            $table->decimal('prime', 10, 2)->nullable();
            $table->string('fournisseur')->nullable();
            $table->string('num_facture')->nullable();
            $table->decimal('montant_facture_usd', 15, 2)->nullable();
            $table->decimal('montant_facture_tnd', 15, 2)->nullable(); // Changer de DECIMAL(10, 2) à DECIMAL(15, 2)
            $table->string('num_conteneur')->nullable();
            $table->string('date_depot')->nullable(); // Peut être modifié en date si nécessaire
            $table->string('transporteur_maritime')->nullable();
            $table->date('date_incident')->nullable();
            $table->string('lieu')->nullable();
            $table->string('mt')->nullable();
            $table->string('date_prev_remboursement')->nullable(); // Peut être modifié en date si nécessaire
            $table->string('nature_de_sinistre')->nullable();
            $table->string('statut_du_dossier')->nullable();
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maritime_sinistres');
    }
};
