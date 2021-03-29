<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderstatus extends Model
{
    protected $fillable = [
        'status','branch_id'
    ];

    protected $table = 'neworder';
}
