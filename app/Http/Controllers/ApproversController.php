<?php

namespace App\Http\Controllers;

use App\Models\AppMessage;
use App\Models\Approvers;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApproversController extends Controller
{
    //
    public function actionApprove(Request $Request)
    {
        try {
            $account_id = \Auth::user()->id;
            $phone_number = \Auth::user()->phone_number;
            $approval_id = $Request->get('approval_id');
            $pin = $Request->get('pin');

            //check pin
            $pin_check = User::get_AccountID($phone_number, $pin);

            if (empty($pin_check)) {
                return AppMessage::get_error_message(401, 'Pin Salah');
            }

            //update status
            $result = Approvers::updateToApproved($account_id, $approval_id);

            //jika update tidak berhasil
            if ($result != 1) {
                throw new Exception($result);
            }

            return AppMessage::default_success_message();

        } catch (Exception $ex) {
            return AppMessage::get_error_message(403, $ex->getMessage());
        }
    }

    public function actionReject(Request $Request)
    {
        try {
            $account_id = \Auth::user()->id;
            $phone_number = \Auth::user()->phone_number;
            $approval_id = $Request->get('approval_id');
            $pin = $Request->get('pin');
            
            //check pin
            $pin_check = User::get_AccountID($phone_number, $pin);
            if (empty($pin_check)) {
                return AppMessage::get_error_message(401, 'Pin Salah');
            }

            //update status
            $result = Approvers::updateToRejected($account_id, $approval_id);

            //jika update tidak berhasil
            if ($result != 1) {
                throw new Exception($result);
            }

            return AppMessage::default_success_message();

        } catch (Exception $ex) {
            return AppMessage::get_error_message(403, $ex->getMessage());
        }
    }

    public function actionExpired()
    {
        try {
        } catch (Exception $ex) {

        }
    }
}
