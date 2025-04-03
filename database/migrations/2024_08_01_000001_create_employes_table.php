<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployesTable extends Migration
{
    public function up()
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->string('MLE', 255)->primary(); // Primary key
            $table->string('Nom');
            $table->string('Prenom');
            $table->string('Zone_geographique');
            $table->string('Site');
            $table->string('Direction');
            $table->string('N+1');
            $table->string('Affectation');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employes');
    }
}
