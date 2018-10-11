<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLipidProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lipid_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serum');
            $table->string('trigly');
            $table->string('hdl');
            $table->string('vldl');
            $table->string('cholestrol');
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
        Schema::dropIfExists('lipid_profiles');
    }
}
