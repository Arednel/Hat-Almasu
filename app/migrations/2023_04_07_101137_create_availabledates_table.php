<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabledatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availabledates', function (Blueprint $table) {
            $table->date('date')->primary();
            $table->tinyInteger('startHour');
            $table->tinyInteger('endHour');
            $table->boolean('isOnline')->default(0);
            $table->integer('examSessionID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availabledates');
    }
}
