<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'user_id','order_id','order_description','order_price','order_status','order_comment','self_pickup','branch_id','latitude','longitude'
    ];

    protected $table = 'orders';
}
