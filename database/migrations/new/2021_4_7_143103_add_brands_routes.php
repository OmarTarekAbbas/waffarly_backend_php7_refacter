<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBrandsRoutes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('routes')->insert(
            array(
            array (
                'method' => 'get',
                'route' => 'brands',
                'controller_name' => 'BrandsController',
                'created_at' => '2019-02-14 13:01:13',
                'updated_at' => '2019-02-14 13:01:13',
                'function_name' => 'index',
            ),
            array (
                'method' => 'get',
                'route' => 'brands/create',
                'controller_name' => 'BrandsController',
                'created_at' => '2019-02-14 13:01:13',
                'updated_at' => '2019-02-14 13:01:13',
                'function_name' => 'create',
            ),
            array (
                'method' => 'post',
                'route' => 'brands',
                'controller_name' => 'BrandsController',
                'created_at' => '2019-02-14 13:01:13',
                'updated_at' => '2019-02-14 13:01:13',
                'function_name' => 'store',
            ),
            array (
                'method' => 'get',
                'route' => 'brands/{id}',
                'controller_name' => 'BrandsController',
                'created_at' => '2019-02-14 13:01:13',
                'updated_at' => '2019-02-14 13:01:13',
                'function_name' => 'show',
            ),
            array (
                'method' => 'get',
                'route' => 'brands/{id}/edit',
                'controller_name' => 'BrandsController',
                'created_at' => '2019-02-14 13:01:13',
                'updated_at' => '2019-02-14 13:01:13',
                'function_name' => 'edit',
            ),
            array (
                'method' => 'patch',
                'route' => 'brands/{id}',
                'controller_name' => 'BrandsController',
                'created_at' => '2019-02-14 13:01:13',
                'updated_at' => '2019-02-14 13:01:13',
                'function_name' => 'update',
            ),
            array (
                'method' => 'get',
                'route' => 'brands/{id}/delete',
                'controller_name' => 'BrandsController',
                'created_at' => '2019-02-14 13:01:13',
                'updated_at' => '2019-02-14 13:01:13',
                'function_name' => 'destroy',
            )
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
