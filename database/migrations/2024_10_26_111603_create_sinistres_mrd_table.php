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
        Schema::create('sinistre_mrds', function (Blueprint $table) {
            $table->id();
            $table->string('numero_sinistre', 30)->nullable(); // Ajout de la colonne si elle n'existe pas
            $table->string('compagnie_assurance')->nullable();
            $table->string('fournisseur')->nullable();
            $table->string('nature_sinistre')->nullable();
            $table->string('lieu_sinistre')->nullable();
            $table->date('date_sinistre')->nullable();
            $table->string('degats')->nullable();
            $table->string('charge')->nullable();
            $table->decimal('perte', 10, 2)->nullable();
            $table->decimal('estimation_de_remboursement', 10, 2)->nullable();
            $table->string('responsable')->nullable();
            $table->text('commentaires')->nullable();
            $table->string('statut')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinistres_mrd');
    }
};
