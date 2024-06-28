<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supportTickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullName', 150);
            $table->string('testType', 150);
            $table->tinyInteger('course');
            $table->string('department', 150);
            $table->string('subject', 150);
            $table->string('mail', 150);
            $table->string('phoneNumber', 150);
            $table->string('reason', 30);
            $table->json('confirmationImages');
            $table->boolean('requestStatus')->default(0);
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
        Schema::dropIfExists('supportTickets');
    }
}
