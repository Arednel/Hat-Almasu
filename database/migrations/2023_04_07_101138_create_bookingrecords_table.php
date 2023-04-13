<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookingrecords', function (Blueprint $table) {
            $table->date('bookingdate');
            $table->bigInteger('requestID')->primary();
            $table->boolean('isOnline')->default(0);
            $table->tinyInteger('startHour')->nullable();
            $table->integer('roomID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookingrecords');
    }
}