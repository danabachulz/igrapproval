<?php

namespace App\Http\Controllers;

use App\Approvers;
use Exception;
use Illuminate\Http\Request;

class ApproversController extends Controller
{
    //
    public function actionApprove()
    {
        try {
            $account_id = request('account_id');
            $approval_id = request('approval_id');

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
            return response()->json([
                'api_status'        => 2,
                'api_message'       => 'gagal',
                'error_code'        => '',
                'error_message'     => $ex->getMessage()
            ]);
        }
    }

    public function actionReject()
    {
        try {
            $account_id = request('account_id');
            $approval_id = request('approval_id');

            $result = Approvers::updateToRejected($account_id, $approval_id);

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
            return response()->json([
                'api_status'        => 2,
                'api_message'       => 'gagal',
                'error_code'        => '',
                'error_message'     => $ex->getMessage()
            ]);
        }
    }

    public function actionExpired()
    {
        try {
        } catch (Exception $ex) {
        }
    }
}
