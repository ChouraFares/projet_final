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
        Schema::create('international_missions', function (Blueprint $table) {
            $table->id();
            $table->string('MLE', 255); // Doit correspondre à la longueur dans 'employes'
            $table->foreign('MLE')->references('MLE')->on('employes')->onDelete('cascade');
            $table->string('mission_id');
            $table->string('user_id');
            $table->string('superviseur');
            $table->string('purpose');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('destination');
            $table->decimal('expenses', 8, 2);
            $table->string('interim');
            $table->string('divers');
            $table->string('mission_report')->nullable();
            $table->string('receipt_path')->nullable();
            $table->string('status')->default('pending');
            $table->text('report_details')->nullable(); // Ajouté
            $table->date('report_date')->nullable(); // Ajouté
            $table->timestamps();
        });

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_missions');
    }
};
