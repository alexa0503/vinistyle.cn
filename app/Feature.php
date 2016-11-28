<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{

    public function images()
    {
        return $this->hasMany('App\MakeupImage');
    }
    public function items()
    {
        return $this->belongsToMany('App\Item', 'feature_items', 'feature_id', 'item_id');
    }
}
