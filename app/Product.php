<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'expire_date',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function posts()
    {
        return $this->hasMany('App\Post', 'content_id', 'id');
    }
    public function operators()
    {
        return $this->belongsToMany('App\Operator', 'posts', 'product_id', 'operator_id')
            ->withPivot('id', 'published_date', 'active', 'url', 'user_id')->withTimestamps();
    }

    // public function scopeOperatorsOpid($builder)
    // {
    //     if (request()->filled("OpID")) {
    //         return $builder->join("categories")
    //     }

    // }

}
