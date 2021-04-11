<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtisalatNotification extends Model
{
    protected $fillable = ['request', 'response', 'MSISDN', 'serviceName', 'tokenId', 'channel', 'operation'] ;

}
