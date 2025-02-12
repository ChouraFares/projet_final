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
        Schema::create('assurances', function (Blueprint $table) {
            $table->id();
            $table->string('MLE'); // Utilisation de MLE au lieu de employe_id
            $table->date('date');
            $table->string('numero_borderaux');
            $table->string('status'); // Livré ou non livré
            $table->timestamps();

            // Définition de la clé étrangère
            $table->foreign('MLE')->references('MLE')->on('employes')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assurances');
    }
};
