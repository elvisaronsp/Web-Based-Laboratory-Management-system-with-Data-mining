<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFullBloodCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('full_blood_counts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('neutrophil');
            $table->string('lymphocytes');
            $table->string('monocytes');
            $table->string('hemoglobin');
            $table->boolean('rbc');
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
        Schema::dropIfExists('full_blood_counts');
    }
}
