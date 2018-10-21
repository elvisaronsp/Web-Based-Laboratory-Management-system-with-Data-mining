<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiverFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liver_functions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('totalProtein');
            $table->string('albumin');
            $table->string('globulin');
            $table->string('alkaline');
            $table->boolean('totalBilirubin');
            $table->boolean('paymentStatus');
            $table->integer('userId');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('liver_functions');
    }
}
