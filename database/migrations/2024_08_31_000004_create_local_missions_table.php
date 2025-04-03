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
        Schema::create('local_missions', function (Blueprint $table) {
            $table->id(); // This creates an auto-incrementing unsignedBigInteger 'id' column
            $table->unsignedBigInteger('user_id'); // Foreign key column
            $table->string('MLE');
            $table->string('mission_id')->unique();
            $table->string('superviseur');
            $table->string('region');
            $table->text('purpose');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('accompanying_person')->nullable();
            $table->string('license_plate')->nullable();
            $table->string('car_type')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('carte_carburant')->nullable();
            $table->decimal('distance_traveled', 8, 2)->nullable();
            $table->decimal('fuel_cost', 8, 2)->nullable();
            $table->decimal('toll_expenses', 8, 2)->nullable();
            $table->enum('hotel', ['oui', 'non'])->default('non')->change();
            $table->decimal('indemnity', 8, 2)->nullable();
            $table->decimal('expenses_with_invoice', 10, 2)->default(0);
            $table->decimal('total_cost', 8, 2)->nullable();
            $table->string('status')->default('pending');
            $table->text('report_details')->nullable();
            $table->date('report_date')->nullable();
            $table->string('receipt_path')->nullable();
            $table->timestamps();

            // Foreign key definition
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local_missions');
    }
};
