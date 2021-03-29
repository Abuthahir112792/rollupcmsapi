<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id ','title','product_description	','product_price','product_qty','image_url','product_status'
    ];

    protected $table = 'product';
}
