<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SitePages extends Model
{
    protected $fillable = [
        'page_title','page_content'
    ];

    protected $table = 'site_pages';
}
