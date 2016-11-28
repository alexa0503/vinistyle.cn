<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerItem extends Model
{
    protected $fillable = [
        'question_id',
        'item_id',
        'answer',
    ];
    public function question()
    {
        return $this->belongsTo('App\Question', 'question_id');
    }
    public function item()
    {
        return $this->belongsTo('App\Item', 'item_id');
    }
}
