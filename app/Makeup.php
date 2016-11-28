<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Makeup extends Model
{
    //
    public function images()
    {
        return $this->hasMany('App\MakeupImage');
    }
    public function features()
    {
        return $this->belongsToMany('App\Feature', 'feature_makeups', 'makeup_id', 'feature_id');
    }
    public function items()
    {
        return $this->belongsToMany('App\Item', 'makeup_items', 'makeup_id', 'item_id');
    }
    public function getPreImgUrlAttribute($value)
    {
        return asset($this->pre_img_path);
    }
}
