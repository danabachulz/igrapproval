<?php

namespace App\Http\Controllers;

use App\Models\AppMessage;
use App\Models\AppVersion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

class SplashController extends Controller
{
    public function splash(Request $Request){
        $token = $Request->get('token');
        $phone_appVersion = $Request->get('app_version');
        $db_appVersion = AppVersion::get_LatestAppVersion();
        if ($phone_appVersion == $db_appVersion) {
            /* condition
              jika nilai tidak sama, cek token
            */
            if (!empty($token)) {
                /* condition
                    token tidak kosong, cek expired
                */

            }
        }
        else {
            /* condition
              jika nilai tidak sama, melakukan cek versi mayor, minor(patch) dan minor(bugfix)
            */
            $phone_version_split = explode(".",$phone_appVersion);
            $db_version_split = explode(".",$db_appVersion);

            if ((int)$phone_version_split[0] < (int)$db_version_split[0]) {
                /* condition for update the phone app
                    nilai mayor versi pada hp tidak sama dengan versi pada database
                */
                return AppMessage::get_error_message('403', 'Versi Terlalu Rendah, Silahkan Download Aplikasi dengan Versi Terbaru');
            }

            else if ((int)$phone_version_split[1] < (int)$db_version_split[1]) {
                /* condition where there is a new patch for the application
                    nilai minor versi pada hp tidak sama dengan versi pada database
                */
                return AppMessage::get_error_message('403', 'Silahkan Update Aplikasi');
            }

            else if ((int)$phone_version_split[2] < (int)$db_version_split[2]) {
                /* condition for update patch for bugfix
                    nilai minor(bugfix) versi pada hp tidak sama dengan versi pada database
                */
                return AppMessage::get_error_message('403', 'Silahkan Update Aplikasi');
            }
            else{
                /* condition : apk mod
                    versi aplikasi pada hp lebih tinggi dari yang terdaftar di server
                */
                return AppMessage::get_error_message('401', 'Aplikasi Anda Tidak Terdaftar !');
            }
        }

        return $phone_version_split.' '.$db_version_split;
    }
}
