<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// Migration for 'internship_requests' table
public function up()
{
    Schema::create('internship_requests', function (Blueprint $table) {
        $table->id();
        $table->string('MLE', 255); // Same length as 'employes' MLE
        $table->foreign('MLE')->references('MLE')->on('employes')->onDelete('cascade');
        $table->string('user_id');

        $table->string('department');
        $table->string('internship_type');
        $table->string('duration');
        $table->text('skills_needed');
        $table->text('further_skills')->nullable();
        $table->date('start_date');
        $table->string('cv_path')->nullable(); // Path to the uploaded CV
        $table->string('status')->default('pending'); // 'pending', 'approved', 'rejected'
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_requests');
    }
};
