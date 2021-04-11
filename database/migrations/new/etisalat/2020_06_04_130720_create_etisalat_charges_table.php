<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtisalatChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etisalat_charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('subscriber_id')->unsigned();
            $table->text('billing_request');
            $table->text('billing_response');
            $table->string('status_code', 100);
            $table->date('charging_date');
            $table->timestamps();
        });
        
        Schema::table('etisalat_charges', function(Blueprint $table)
		{
            $table->foreign('subscriber_id', 'subscriber_fk_1')->references('id')->on('etisalat_msisdns')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etisalat_charges');
    }
}
