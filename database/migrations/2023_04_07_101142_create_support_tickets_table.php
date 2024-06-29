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
            $table->string('fullName', 200);
            $table->string('testType', 200);
            $table->tinyInteger('course');
            $table->string('department', 200);
            $table->string('subject', 200);
            $table->string('email', 200);
            $table->string('phoneNumber', 200);
            $table->text('extraTextInfo')->nullable();
            $table->string('reason', 200);
            $table->json('confirmationImages');
            $table->string('supportTicketStatus')->default('На рассмотрении');
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
