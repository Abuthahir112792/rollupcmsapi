<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLoginOtp extends Model
{
    protected $fillable = [
        'user_id','otp'
    ];

    protected $table = 'user_login_opts';

}
