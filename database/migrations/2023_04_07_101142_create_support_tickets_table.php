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
        Schema::create('supporttickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullName', 200);
            $table->tinyInteger('course');
            $table->string('department', 200);
            $table->string('email', 200);
            $table->string('phoneNumber', 200);
            $table->text('extraTextInfo')->nullable();
            $table->string('reason', 200);
            $table->string('student_login', 200)->nullable();
            $table->string('student_password', 200)->nullable();
            $table->text('subjects_to_add')->nullable();
            $table->text('subjects_to_remove')->nullable();
            $table->text('stuff_comment')->nullable();
            $table->json('confirmationImages')->nullable();
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
        Schema::dropIfExists('supporttickets');
    }
}
