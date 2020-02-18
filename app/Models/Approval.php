<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $table = 'approval';

    public static function getApproval_Details($approval_id){
        $approval_status = Approval::select('approval.*','priority.description AS priority')
                            ->join('priority','approval.priority','priority.id')
                            ->where('approval.id',$approval_id)
                            ->first();
        return $approval_status;
    }

    public static function check_LowerLevel_Approval($job_level,$branch_id){
        // get lower level user approval status
        $approval_list = Approval::select('approvers.id','approvers.approval_id','approvers.approval_status')
                            ->join('approvers','approvers.approval_id','approval.id')
                            ->join('accounts','approvers.account_id','accounts.id')
                            ->join('position','accounts.position_id','position.id')
                            //->where('approvers.approval_status',3)
                            ->where('position.job_level_id',$job_level-1)
                            ->where('accounts.branch_id',$branch_id)
                            ->where('approval.due_date', '>=', date('Y-m-d H:i:s'))
                            ->orderBy('approval.priority', 'desc')
                            ->get();

        return $approval_list;
    }

    public static function get_ApprovalStatus($approval_id,$user_id){
        //check approval status by user id
        $approval_status = Approval::select('approval.id AS approval_id','approvers.approval_status')
                            ->join('approvers','approvers.approval_id','approval.id')
                            ->join('accounts','approvers.account_id','accounts.id')
                            ->join('position','accounts.position_id','position.id')
                            ->where('approval.id',$approval_id)
                            ->where('accounts.id',$user_id)
                            ->first();
        return $approval_status;
    }

    public static function get_All_ActiveApproval(){
        $approval_status = Approval::select('approval.*','priority.description AS priority')
                            ->join('priority','approval.priority','priority.id')
                            ->join('approvers','approvers.approval_id','approval.id')
                            ->where('approvers.approval_status','!=',3)
                            ->where('approval.due_date', '>=', date('Y-m-d H:i:s'))
                            ->get();
        return $approval_status;
    }
}
