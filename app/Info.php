<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    //
    //public $timestamps = false;
    protected $fillable = ['name','address','mobile','ip_address','id'];
    public function lottery()
    {
        return $this->belongsTo('App\Lottery');
    }
}
