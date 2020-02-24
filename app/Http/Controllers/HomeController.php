<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Approval;
use App\Models\Approvers;
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
        /* home controller
            menampilkan seluruh aproval yang masih aktif dan belum dikerjakan oleh user
        */
        try {
            $user_id = \Auth::user()->id;
            $account_name = \Auth::user()->name;
            $job_level = Position::get_JobLevel(\Auth::user()->position_id);
            $branch_id = \Auth::user()->branch_id;

            //if user have the lowest job level
            if ($job_level == 1) {
                return $this->specialCase_Approval($account_name);
            }

            //get the list of approval from lower user
            $approval = Approval::check_LowerLevel_Approval($job_level,$branch_id);

            if(empty($approval)){
                return $this->specialCase_Approval($account_name);
            }

            $appresponse['account_name'] = $account_name;
            $appresponse['total_approval'] =(string) count($approval);
            $appresponse['approval_list'] = $approval;
            //the response
            return AppMessage::get_home($appresponse);

        } catch (Exception $ex) {
            return AppMessage::get_error_message(401, $ex->getMessage());
        }
    }

    private static function specialCase_Approval($account_name){
        /*
            Special-Case
            dimana jika user memiliki posisi paling rendah atau tidak memiliki bawahan
            approval aktif yg masih pending akan diambil langsung
        */
        $approval = Approval::get_All_Approval();
        $appresponse['account_name'] = $account_name;
        $appresponse['total_approval'] =(string) count($approval);
        if (empty($approval)) {
            $approval='';
        }
        $appresponse['approval_list'] = $approval;
        //the response
        return AppMessage::get_home($appresponse);
    }

    public function approval_history(Request $Request){
        try{
            /* approval history controller
                menampilkan aproval yang telah di kerjakan oleh user,
                maximum item yg di tampilkan sebanyak 15 opproval terakhir yang telah selesai
                optional :
                > mengurutkan berdasarkan priority
                > filter : status, priority, &hari
                > pencarian berdasarkan keyword/katakunci
            */
            $user_id = \Auth::user()->id;
            $account_name = \Auth::user()->name;

            //the search keyword
            $search_key = $Request->get('keyword');

            /*the sort keyword, mengurutkan approval yang muncul pada list berdasarkan
                0 = by last date
                1 = asc
                2 = desc
            */
            if(!empty($Request->get('sort_id'))){
                $sortBy = $Request->get('sort_id');
            }else{
                $sortBy =0;
            }

            // the filters
            $filter['status'] = $Request->get('status');
            $filter['priority'] = $Request->get('priority');
            $filter['date_start'] = $Request->get('date_start');
            $filter['date_end'] = $Request->get('date_end');

            $approval = Approval::get_ApprovalHistory($user_id,$search_key,$filter,$sortBy);

            try{
                $approval_count = (string) count($approval);
            }catch(Exception $ex){
                $approval_count = '0';
            }

            $appresponse['account_name'] = $account_name;
            $appresponse['total_approval'] =$approval_count;

            if (empty($approval)) {
                $approval='';
            }

            $appresponse['approval_list'] = $approval;
            //the response
            return AppMessage::get_home($appresponse);

        }catch (Exception $ex) {
            return AppMessage::get_error_message(401, $ex->getMessage());
        }

    }

    public function approval_detail(Request $Request){
        try{
            $approval_id = $Request->get('approval_id');

            // ambil detail approval
            $appresponse['approval_detail'] = Approval::getApproval_Details($approval_id);

            // ambil semua user yg melakukan aksi pada approval
            $appresponse['approvers'] = Approvers::getByApprovalId($appresponse['approval_detail']->id);

            return AppMessage::get_approvalDetails($appresponse);

        }catch (Exception $ex) {
            return AppMessage::get_error_message(401, $ex->getMessage());
        }

    }
}
