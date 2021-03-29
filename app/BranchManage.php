<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchManage extends Model
{
    protected $fillable = [
        'address','lat','long'
    ];

    protected $table = 'branchmanage';
}
