<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('requestID');
            $table->string('fullName', 150);
            $table->integer('idOfTest');
            $table->string('faculty', 150);
            $table->string('speciality', 150);
            $table->tinyInteger('course');
            $table->string('department', 150);
            $table->string('subject', 150);
            $table->string('mail', 150);
            $table->string('phoneNumber', 150);
            $table->string('reason', 30);
            $table->string('examType', 30);
            $table->binary('confirmationFile');
            $table->boolean('requestStatus')->default(0);
            $table->integer('examSessionID');
            $table->dateTime('created_at')->useCurrent();
        });

        DB::statement("ALTER TABLE `requests` MODIFY `confirmationFile` MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}