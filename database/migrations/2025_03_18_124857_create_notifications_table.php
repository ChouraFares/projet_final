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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Colonne auto-incrémentée pour la clé primaire
            $table->string('type'); // Type de notification (ex. 'prepayment')
            $table->string('facture_number'); // Numéro de la facture
            $table->string('fournisseur'); // Nom du fournisseur
            $table->datetime('date_demande'); // Date de la demande
            $table->boolean('is_read')->default(false); // Statut de lecture (false par défaut)
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications'); // Supprime la table si la migration est annulée
    }
};