<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppMessage extends Model
{
    // Created : 16/01/2020
    // Updated : 21/01/2020
    // this table contains all app json message

    // the error code and message
    public static function get_error_message($error_code, $error_message){
        return response()->json([
            'api_status' => 2,
            'api_message' => 'sukses',
            'error_code' => $error_code,
            'error_message' => $error_message
        ], $error_code);
    }

    public static function get_login_message($appresponse){
        return response()->json([
            'api_status' => 1,
            'api_message' => 'sukses',
            'user_detail' => $appresponse['user_detail'],
            'access_token' => $appresponse['token'],
            'token_type' => 'Bearer',
            'error_code' => '',
            'error_message' => ''
        ], 200);
    }

    public static function get_register_message(){
        return response()->json([
            'api_status' => 1,
            'api_message' => 'sukses',
            'register_message' => 'Registrasi Berhasil',
            'error_code' => '',
            'error_message' => ''
        ], 200);
    }
}
