<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('product_image');
			$table->integer('category_id')->unsigned()->index('products_category_id_foreign');
			$table->integer('brand_id')->unsigned()->index('products_brand_id_foreign');
			$table->timestamps();
			$table->string('title');
			$table->boolean('featured')->default(0);
			$table->date('show_date')->nullable();
			$table->date('expire_date');
			$table->boolean('active');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
