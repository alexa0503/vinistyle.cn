<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MakeupImage extends Model
{
    //
    public function user()
    {
        return $this->belongsTo('App\Makeup', 'makeup_id');
    }
    public function getUrlAttribute($value)
    {
        return asset($this->path);

    }
}
