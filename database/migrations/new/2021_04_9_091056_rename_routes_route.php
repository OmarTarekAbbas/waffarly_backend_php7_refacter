<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameRoutesRoute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::raw("UPDATE routes SET route = 'routess' WHERE routes.id = 40");
        DB::raw("UPDATE routes SET route = 'routess' WHERE routes.id = 40");
        \DB::statement("ALTER TABLE `providers` CHANGE `image` `image` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;");
        \DB::statement("ALTER TABLE `posts` CHANGE `content_id` `product_id` INT(10) UNSIGNED NOT NULL;");
        \DB::statement("ALTER TABLE `posts` DROP FOREIGN KEY `posts_content_id_foreign`; ALTER TABLE `posts` ADD CONSTRAINT `posts_content_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
