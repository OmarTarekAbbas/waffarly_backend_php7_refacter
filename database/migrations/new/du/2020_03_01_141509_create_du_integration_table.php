<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDuIntegrationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('du_integration', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('url', 400);
			$table->char('trxid', 36);
			$table->string('uid', 20);
			$table->string('serviceid', 20);
			$table->string('plan', 10);
			$table->string('price', 10);
			$table->timestamps();
			$table->string('local', 4);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('du_integration');
	}

}
