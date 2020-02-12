<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    // model otp
    public static function set_otp(){
        return rand(100000,999999);
    }

}
