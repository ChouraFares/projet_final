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
        Schema::create('loan_requests', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('MLE', 255); // Doit correspondre à la longueur dans 'employes'
            $table->foreign('MLE')->references('MLE')->on('employes')->onDelete('cascade');
            $table->string('Direction');
            $table->decimal('amount', 10, 2);
            $table->string('purpose');
            $table->string('type'); // Type of Loan/Advance
            $table->string('repayment_month'); // First Month of Repayment
            $table->string('additional_documents_path')->nullable(); // Additional Documents (optional)
            $table->string('status')->default('pending'); // Default status
            $table->timestamps(); // Timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_requests');
    }
};
