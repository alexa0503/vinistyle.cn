<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RichList extends Model
{
    //
    public function user()
    {
        return $this->belongsTo('App\WechatUser');
    }
}
