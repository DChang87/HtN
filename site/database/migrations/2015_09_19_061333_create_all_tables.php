<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid');
            $table->string('name');
            $table->string('age');
            $table->timestamps();
        });
        Schema::create('patient_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id');
            $table->integer('plan_id');
            $table->timestamps();
        });
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('med_id');
            $table->integer('interval');
            $table->integer('offset');
            $table->string('dose');
            $table->integer('repeats');
            $table->timestamps();
        });
        Schema::create('meds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('manufacturer');
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
        Schema::drop('meds');
        Schema::drop('plans');
        Schema::drop('patient_plan');
        Schema::drop('patients');
    }
}
