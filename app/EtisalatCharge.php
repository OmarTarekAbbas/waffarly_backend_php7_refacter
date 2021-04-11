<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtisalatCharge extends Model
{
    protected $fillable = ['subscriber_id', 'billing_request', 'billing_response', 'status_code', 'charging_date'] ;
}
