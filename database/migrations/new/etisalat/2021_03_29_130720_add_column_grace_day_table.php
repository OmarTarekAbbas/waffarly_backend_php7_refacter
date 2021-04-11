<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnGraceDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::statement("ALTER TABLE `etisalat_msisdns` ADD `grace_days` INT(10) NULL DEFAULT NULL AFTER `charging_cron`;");
      DB::statement("ALTER TABLE `etisalat_msisdns` CHANGE `final_status` `final_status` VARCHAR(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '0=Unsub / 1=Sub / 2=ChargingPending ';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
