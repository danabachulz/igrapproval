<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $table = 'approval';

    public static function getApproval_List(){

    }

    public static function check_LowerLevel_ApprovalStatus($account_id,$branch_id,$approval_id){
        // get lower level account
            $approval_status = \DB::table('approvers')
                                ->select('approvers.id, position.id')
                                ->join('accounts',function($join){
                                    $join->on('approvers.account_id','accounts.id');
                                    $join->on('position.id','accounts.position_id');
                                })
                                ->where('accounts.branch_id',$branch_id)
                                ->where('');

    }
}
