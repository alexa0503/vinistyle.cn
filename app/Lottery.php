<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    //
    public $timestamps = false;

    public function prizeCode()
    {
        return $this->belongsTo('App\PrizeCode');
    }
    public function prizeInfo()
    {
        return $this->belongsTo('App\Prize', 'prize_id');
    }
    public function info()
    {
        return $this->hasOne('App\Info');
    }
}
