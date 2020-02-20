<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppMessage extends Model
{
    // this table contains all app json message
    /*
        APP Error Code
        401 = Unauthorized/Cant access using current user ID
        403 = Unauthorized Known User / Forbidden Access
        404 = FCM
        500 = Server Error
    */

    // the json message
    public static function default_success_message(){
        return response()->json([
            'api_status' => 1,
            'api_message' => 'sukses',
            'error_code' => '',
            'error_message' => ''
        ], 200);
    }
    public static function get_error_message($error_code, $error_message){
        return response()->json([
            'api_status' => 2,
            'api_message' => 'sukses',
            'error_code' => (string)$error_code,
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

    public static function get_home($appresponse){
        return response()->json([
            'api_status' => 1,
            'api_message' => 'sukses',
            'account_name' => $appresponse['account_name'],
            'total_approval' =>$appresponse['total_approval'],
            'approval_list' => $appresponse['approval_list'],
            'error_code' => '',
            'error_message' => ''
        ], 200);
    }

    public static function get_approvalDetails($appresponse){
        return response()->json([
            'api_status' => 1,
            'api_message' => 'sukses',
            'approval_detail' => $appresponse['approval_detail'],
            'approvers' =>$appresponse['approvers'],
            'error_code' => '',
            'error_message' => ''
        ], 200);
    }

}
