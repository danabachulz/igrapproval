<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AppMessage;
use App\Models\FcmToken;
use App\Models\OTP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

class UserController extends Controller
{
    public function register(Request $Request){

        try {
        //Validasi apakah email sudah terdaftar
        $userAssoc = User::Where('phone_number', $Request->phone_number)->Get()->Count();

        if($userAssoc > 0) {
            return AppMessage::get_error_message(401, 'Akun sudah terdaftar');
        }

            try{
                $newU = new User;
                $newU->name = $Request->get('name');
                $newU->phone_number = $Request->get('phone_number');
                $newU->pin = bcrypt($Request->get('pin'));
                $newU->email = $Request->get('email');
                $newU->position_id = $Request->get('position_id');
                $newU->branch_id = $Request->get('branch_id');
                $newU->save();

                return AppMessage::get_register_message();
            }
            catch(Exception $ex){
                return AppMessage::get_error_message(401, 'Registrasi gagal : '.$ex->getMessage());
            }
        }catch(Exception $ex){
            return AppMessage::get_error_message(401, 'Registrasi gagal : '.$ex->getMessage());
        }
    }

    public function login(Request $Request){

        $id = User::get_AccountID($Request->get('phone_number'),$Request->get('pin'));

            if (empty($id)) {
                return AppMessage::get_error_message(401, 'Nomor Handphone atau Pin Salah');
            }
        //check fcm
        // try{
        //     $fcm_count = FcmToken::get_fcm_count($id,$Request->get('fcm'));
        // }catch(Exception $ex){
        //     $fcm_count = 0;
        // }
        // if ($fcm_count<1) {
        //     //send otp first
        //     $otp = OTP::set_otp();//belum selesai
        //     //set fcn
        //     FcmToken::set_fcm_token($id,$Request->get('fcm'));
        // }

            //create auth
        Auth::loginUsingId($id);

        $user = $Request->user();
        $appresponse['token'] = $user->createToken('Token Name')->accessToken;
        $appresponse['user_detail'] = User::get_AccountInfo($id);
        return AppMessage::get_login_message($appresponse);

    }

    public function splash(Request $Request){


    }
}
