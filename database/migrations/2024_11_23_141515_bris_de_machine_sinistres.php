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
        Schema::create('bris_de_machine_sinistres', function (Blueprint $table) {
            $table->id();
            $table->string('numero_sinistre')->unique();
            $table->string('assureur');
            $table->string('nature_sinistre');
            $table->string('lieu_sinistre');
            $table->date('date_sinistre');
            $table->text('degats')->nullable();
            $table->string('charge')->nullable();
            $table->decimal('perte', 15, 2)->nullable();
            $table->string('responsable')->nullable();
            $table->string('statu_du_dossier')->nullable();
            $table->string('expert')->nullable();
            $table->text('commentaires')->nullable();
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
