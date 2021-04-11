<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtisalatMsisdn extends Model
{
    protected $fillable = ['MSISDN', 'record_id', 'final_status', 'next_charging_date', 'charging_cron', 'subscribe_date'] ;
}
