<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statuslist extends Model
{
    protected $fillable = [
        'status_name','status_status'
    ];

    protected $table = 'statuslist';
}
