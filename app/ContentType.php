<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    protected $fillable = ['title'];

    public function contents()
    {
        return $this->hasMany('App\Content', 'content_type_id', 'id');
    }
    public function getContentType($value)
    {
        if (is_int($value)) {
            return $x = ContentType :: where($value,'id')->get()->title;
        } else {
            return $x = ContentType :: where($value,'id')->get()->id;
        }
    }
}
