<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sitesettings', function (Blueprint $table) {
            $table->enum('id', ['1'])->primary();
            $table->bigInteger('currentExamSessionID')->default(1);
            $table->boolean('canSendRequests')->default(1);
        });

        DB::table('sitesettings')
            ->insert(
                array(
                    'id' => '1',
                    'currentExamSessionID' => '1',
                    'canSendRequests' => '1'
                )
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sitesettings');
    }
}
