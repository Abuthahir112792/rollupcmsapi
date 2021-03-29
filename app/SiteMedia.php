<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteMedia extends Model
{
    protected $fillable = [
        'media_name','media_type'
    ];

    protected $table = 'site_media';
}
