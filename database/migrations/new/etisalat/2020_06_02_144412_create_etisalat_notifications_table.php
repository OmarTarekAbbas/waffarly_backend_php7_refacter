<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtisalatNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etisalat_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('request');
            $table->text('response')->nullable();
            $table->string('MSISDN', 90)->nullable();
            $table->string('serviceName', 90)->nullable();
            $table->string('tokenId', 90)->nullable();
            $table->string('channel', 90)->nullable();
            $table->string('operation', 90)->nullable();
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
        Schema::dropIfExists('etisalat_notifications');
    }
}
