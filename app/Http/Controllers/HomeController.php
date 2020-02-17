<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Approval;
use App\Models\AppMessage;
use App\Models\Position;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

class HomeController extends Controller
{
    public function home(){
        try {
            $user_id = \Auth::user()->id;
            $account_name = \Auth::user()->name;
            $job_level = Position::get_JobLevel(\Auth::user()->position_id);
            $branch_id = \Auth::user()->branch_id;

            //if user have the lowest job level
            if ($job_level == 1) {
                # code...
            }

            //get the list of approval from lower user
            $approval = Approval::check_LowerLevel_Approval($job_level,$branch_id);

            //get all the approval that already accept by lower lever user && have pending status on current user
            $app_list = [];
            foreach ($approval as $app) {
                if ($app->approval_status == 3) {
                    $app_status = Approval::get_ApprovalStatus($app->approval_id,$user_id);
                    if (empty($app_status)||$app_status->approval_status == 1) {
                        $appDetail = Approval::getApproval_Details($app->approval_id);
                        $app_list [] = $appDetail;
                    }
                }
            }

            $appresponse['account_name'] = $account_name;
            $appresponse['total_approval'] = count($app_list);
            $appresponse['approval_list'] = $app_list;
            //the response
            return AppMessage::get_home($appresponse);

        } catch (Exception $ex) {
            return AppMessage::get_error_message(401, $ex->getMessage());
        }
    }
}
