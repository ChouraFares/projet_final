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
        Schema::create('assurance_maladie', function (Blueprint $table) {
            $table->id();
            $table->date('date_envoi');
            $table->string('numero_borderaux');
            $table->string('bulletin_numero');
            $table->string('nom_adherent');
            $table->date('date_de_soin');
            $table->enum('status', ['Remis', 'Non Remis', 'Cloturé']);
            $table->text('reclamation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assurance_maladie');
    }
};
