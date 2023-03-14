<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->tinyInteger('isOnline')->default(0);
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
};
