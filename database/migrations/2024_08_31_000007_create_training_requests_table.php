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
         Schema::create('training_requests', function (Blueprint $table) {
             $table->id();
             $table->string('MLE', 255); // Doit correspondre à la longueur dans 'employes'
             $table->foreign('MLE')->references('MLE')->on('employes')->onDelete('cascade');
               $table->string('department');
               $table->string('user_id');

             $table->string('selected_training');
             $table->string('status')->default('en attente');
             $table->timestamps();
         });
     }

     public function down(): void
     {
         Schema::dropIfExists('training_requests');
     }
};
