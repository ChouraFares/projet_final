<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('responsable_civil_sinistres', function (Blueprint $table) {
            $table->id();
            $table->string('numero_de_sinistre'); // Numéro de sinistre
            $table->string('assureur'); // Assureur
            $table->string('nature_sinistre'); // Nature du sinistre
            $table->string('lieu_sinistre'); // Lieu du sinistre
            $table->date('date_sinistre'); // Date du sinistre
            $table->text('degats')->nullable(); // Description des dégâts
            $table->string('charge')->nullable(); // Chargé de l'affaire
            $table->decimal('perte', 15, 2)->nullable(); // Montant de la perte
            $table->string('responsable')->nullable(); // Responsable du sinistre
            $table->string('situation_du_dossier')->nullable(); // Situation du dossier
            $table->text('commentaires')->nullable(); // Commentaires supplémentaires
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('responsable_civil_sinistres');
    }
};
