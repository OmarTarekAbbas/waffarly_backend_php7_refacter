<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes ;

class Product extends Model
{

    protected $fillable = [
        'product_image',
        'category_id',
        'brand_id',
        'title',
        'active',
        'featured',
        'show_date',
        'expire_date'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

   

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

   public function operators()
   {
       return $this->belongsToMany('App\Operator','posts','product_id','operator_id')->wherePivot('active',1)->wherePivot('show_date','<=',Carbon::now());
   }
   public function posts()
   {
       return $this->hasMany('App\Post', 'content_id', 'id');
   }

}
