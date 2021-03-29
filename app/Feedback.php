<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'user_id','feedback_rate','feedback_description'
    ];

    protected $table = 'feedback';
}
