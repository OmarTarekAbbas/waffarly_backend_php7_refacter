<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class DuIntgration extends Model
{
    
    protected $table = 'du_integration' ;

    protected $fillable = [
        'url',
        'trxid' ,
        'uid' ,
        'serviceid' ,
		'plan' ,
        'price'
        
    ];
   
}
