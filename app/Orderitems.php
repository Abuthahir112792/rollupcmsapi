<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderitems extends Model
{
    protected $fillable = [
        'product_id','item_order_id','orderitems_price','orderitems_qty'
    ];

    protected $table = 'orderitems';
}
