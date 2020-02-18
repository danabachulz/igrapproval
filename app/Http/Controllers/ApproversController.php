<?php

namespace App\Http\Controllers;

use App\Models\Approvers;
use App\Models\AppMessage;
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
            $approval_id = $Request->get('approval_id');

            $result = Approvers::updateToApproved($account_id, $approval_id);

            //jika update tidak berhasil
            if ($result != 1) {
                throw new Exception($result);
            }

            return response()->json([
                'api_status'        => 1,
                'api_message'       => 'sukses',
                'error_code'        => '',
                'error_message'     => ''
            ]);
        } catch (Exception $ex) {
            return AppMessage::get_error_message(401, $ex->getMessage());
        }
    }

    public function actionReject(Request $Request)
    {
        try {
            $account_id = \Auth::user()->id;
            $approval_id = $Request->get('approval_id');

            $result = Approvers::updateToRejected($account_id, $approval_id);
            
            //jika update tidak berhasil
            if ($result != 1) {
                throw new Exception($result);
            }

            return response()->json([
                'api_status'        => 1,
                'api_message'       => 'sukses',
                'error_code'        => '',
                'error_message'     => ''
            ]);
        } catch (Exception $ex) {
            return AppMessage::get_error_message(401, $ex->getMessage());
        }
    }

    public function actionExpired()
    {
        try {
        } catch (Exception $ex) {
        }
    }
}
