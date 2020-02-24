<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $table = 'approval';

    public static function getApproval_Details($approval_id){
        $approval_status = Approval::Distinct()
                            ->select('approval.*','priority.description AS priority','approval_status.description AS status')
                            ->join('priority','approval.priority','priority.id')
                            ->join('approvers','approvers.approval_id','approval.id')
                            ->join('approval_status','approvers.approval_status','approval_status.id')
                            ->where('approvers.approval_status',1)
                            ->where('approval.id',$approval_id)
                            ->first();
        return $approval_status;
    }

    public static function check_LowerLevel_Approval($job_level,$branch_id){
        // get lower level user approval status
        /*
            berisikan luaran id approval yang tidak/belum di setujui bawahan user
        */
        $approval_list = Approval::Distinct()
                            ->select('approvers.approval_id')
                            ->join('approvers','approvers.approval_id','approval.id')
                            ->join('accounts','approvers.account_id','accounts.id')
                            ->join('position','accounts.position_id','position.id')
                            ->where('approvers.approval_status','!=',3)
                            ->where('position.job_level_id',$job_level-1)
                            ->where('accounts.branch_id',$branch_id)
                            ->where('approval.due_date', '>=', date('Y-m-d H:i:s'))
                            ->orderBy('approval.priority', 'desc')
                            ->get();

        /*
        hasil digunakan untuk seleksi approval yang akan di tampilkan
        approval yang akan tampil adalah: approval yang telah di setujui bawahan
        atau approval yang belum disetujui user dan bawahan tidak boleh ikut melakukan persetujuan
        */

        $approval = self::get_CombinedApproval($approval_list);

        return $approval;
    }

    public static function get_CombinedApproval($approval_list){
        //return $approval_list;
        /*
        membandingkan aproval, mengabil seluruh approval yg belum di lakukan user
        kemudian membandingkannya dengan approval yang belum disetujui bawahan dari user
        */
        $approval = self::get_All_Approval();

        if ($approval_list->isEmpty()) {
            return $approval;
        }
        foreach ($approval as $app) {
            foreach ($approval_list as $app_list) {
                if ($app->id != $app_list->approval_id) {
                    $hasil [] = $app;
                }
            }
        }
        return $hasil;
    }

    public static function get_ApprovalStatus($approval_id,$user_id){
        //check approval status by user id
        $approval_status = Approval::Distinct()
                            ->select('approval.id AS approval_id','approvers.approval_status')
                            ->join('approvers','approvers.approval_id','approval.id')
                            ->join('accounts','approvers.account_id','accounts.id')
                            ->join('position','accounts.position_id','position.id')
                            ->where('approval.id',$approval_id)
                            ->where('accounts.id',$user_id)
                            ->first();
        return $approval_status;
    }

    public static function get_All_Approval(){
        $approval_list = Approval::Distinct()
                        ->select('approval.*','priority.description AS priority','approval_status.description AS status')
                        ->join('approvers','approvers.approval_id','approval.id')
                        ->join('priority','approval.priority','priority.id')
                        ->join('approval_status','approvers.approval_status','approval_status.id')
                        ->where('approvers.approval_status',1)
                        ->where('approvers.account_id',\Auth::user()->id)
                        ->where('approval.due_date', '>=', date('Y-m-d H:i:s'))
                        ->orderBy('approval.priority', 'desc')
                        ->get();

        return $approval_list;
    }

    public static function get_ApprovalHistory($id,$search_key,$filter,$sortBy){

        $approval_list = Approval::Distinct()
                        ->select('approval.*','priority.description AS priority','approval_status.description AS status')
                        ->join('approvers','approvers.approval_id','approval.id')
                        ->join('priority','approval.priority','priority.id')
                        ->join('approval_status','approvers.approval_status','approval_status.id')
                        ->where('approvers.account_id',$id)
                        ->where('approvers.approval_status','!=',1)
                        ->where('approval.title','LIKE','%'.$search_key.'%')
                        ->orderBy('approval.due_date','desc');
                //sorting section
                if ($sortBy == 1) {
                    $approval_list->orderBy('approval.priority', 'asc');
                }else if ($sortBy == 2) {
                    $approval_list->orderBy('approval.priority', 'desc');
                }

                //filter section
                if ($filter['status'] != null ) {
                    $approval_list->where('approvers.approval_status',$filter['status']);
                }
                if ($filter['priority'] != null ) {
                    $approval_list->where('approval.priority',$filter['priority']);
                }
                if ($filter['date_start'] != null) {
                    $approval_list->where('approval.due_date','>=',$filter['date_start']);
                }
                if ($filter['date_end'] != null) {
                    $approval_list->where('approval.due_date','<=',$filter['date_end']);
                }
                // hitung banyak hasil
                $app_count = $approval_list->count();

                if ($app_count > 15) {
                     $approval_list = $approval_list->take(1)->get();
                }else{
                    $approval_list = $approval_list->get();
                }


        return $approval_list;
    }
}
