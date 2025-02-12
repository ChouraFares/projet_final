<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancesTable extends Migration
{
    public function up()
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('numero_bordereau');
            $table->string('MLE');  // Référence à la table 'employes'
            $table->string('employee_name');
            $table->string('employee_surname');
            $table->enum('status', ['livré', 'non livré']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('insurances');
    }
}
