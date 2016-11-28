<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    public function getPreImgUrlAttribute($value)
    {
        return asset($this->pre_img_path);

    }
    public function type()
    {
        return $this->belongsTo('App\ItemType');
    }
}
