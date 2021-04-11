<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtisalatMsisdnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etisalat_msisdns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('MSISDN', 90)->nullable()->index();
			$table->biginteger('record_id')->unsigned();
            $table->string('final_status', 90)->nullable();
            $table->timestamps();
        });

        Schema::table('etisalat_msisdns', function(Blueprint $table)
		{
            $table->foreign('record_id', 'record_fk_1')->references('id')->on('etisalat_notifications')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etisalat_msisdns');
    }
}
