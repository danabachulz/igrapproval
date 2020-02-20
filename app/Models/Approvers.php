<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Approvers extends Model
{
    protected $table = 'approvers';
    /*
    getByAccountId()
    mencari semua data approval berdasarkan account_id
     */
    public static function getByAccountId($account_id)
    {
        $approvers = Approvers::Distinct()
            ->select('*')
            ->where('account_id', '=', $account_id)
            ->get();
        return $approvers;
    }

    /*
    getByApprovalId()
    mencari semua data approvers berdasarkan approval_id
     */
    public static function getByApprovalId($approval_id)
    {
        //
        $approvers = Approvers::Distinct()
            ->join('accounts', 'approvers.account_id', '=', 'accounts.id')
            ->join('position', 'accounts.position_id', '=', 'position.id')
            ->join('approval_status','approvers.approval_status','approval_status.id')
            ->select(
                'accounts.id AS account_id',
                'accounts.name',
                'approvers.approval_status',
                'approval_status.description AS status',
                'approvers.date',
                'approvers.note',
                'position.job_level_id',
                'position.description AS job_description'
            )
            ->where('approvers.approval_id', '=', $approval_id)
            ->orderBy('position.job_level_id', 'DESC')
            ->get();
        return $approvers;
    }

    /*
    getTotalApprovalByAccountId
    mencari total approval yang ada berdasarkan account_id
     */
    public static function getTotalApprovalByAccountId($account_id)
    {
        $TotalApproval = Approvers::Distinct()
            ->select('id')
            ->where('account_id', '=', $account_id)
            ->get();
        return $TotalApproval->count();
    }

    /*
    getTotalApprovedByAccountId
    mencari total approval yang sudah approved berdasarkan account_id
     */
    public static function getTotalApprovedByAccountId($accountId)
    {
        $TotalApproved = Approvers::Distinct()
            ->select('id')
            ->where('account_id', '=', $accountId)
            ->where('approval_status', '=', 3)
            ->get();
        return $TotalApproved->count();
    }

    /*
    getTotalRejectedByAccountId()
    mencari total approval yang sudah rejected berdasarkan account_id
     */
    public static function getTotalRejectedByAccountId($accountId)
    {
        $TotalRejected = Approvers::Distinct()
            ->select('id')
            ->where('account_id', '=', $accountId)
            ->where('approval_status', '=', 2)
            ->get();
        return $TotalRejected->count();
    }

    /*
    getApprovalStatus()
    mencari approval status berdasarkan account_id dan approval_id
     */
    public static function getApprovalStatus($account_id, $approval_id)
    {
        try {
            $result = Approvers::Distinct()
                ->select('approval_status')
                ->where('account_id', '=', $account_id)
                ->where('approval_id', '=', $approval_id)
                ->first();
            if (!$result) {
                throw new Exception("Error Query " . $account_id . "-" . $approval_id);
            }
            return $result->approval_status;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /*
    updateToApproved()
    merubah status approval menjadi approved
     */
    public static function updateToApproved($account_id, $approval_id, $note)
    {
        try {
            //cek approval status
            $approval_status = Approvers::getApprovalStatus($account_id, $approval_id);
            if ($approval_status == 4) {
                throw new Exception("Expired");
            } elseif ($approval_status == 3) {
                throw new Exception("Already Approved");
            } elseif ($approval_status == 2) {
                throw new Exception("Already Reject");
            } elseif ($approval_status != 1) {
                throw new Exception($approval_status);
            }

            //run sql
            $result = Approvers::Distinct()
                ->where('account_id', '=', $account_id)
                ->where('approval_id', '=', $approval_id)
                ->update(['approval_status' => "3", 'note' => $note]);
            if (!$result) {
                throw new Exception("Nothing Change");
            }
            //jika berhasil return 1
            return '1';
        } catch (Exception $ex) {
            //jika gagal return pesan gagal
            return $ex->getMessage();
        }
    }

    /*
    updateToRejected()
    merubah status approval menjadi rejected
     */
    public static function updateToRejected($account_id, $approval_id, $note)
    {
        try {
            //cek approval status
            $approval_status = Approvers::getApprovalStatus($account_id, $approval_id);
            if ($approval_status == 4) {
                throw new Exception("Expired");
            } elseif ($approval_status == 3) {
                throw new Exception("Already Approved");
            } elseif ($approval_status == 2) {
                throw new Exception("Already Reject");
            } elseif ($approval_status != 1) {
                throw new Exception($approval_status);
            }

            //run sql
            $result = Approvers::Distinct()
                ->where('account_id', '=', $account_id)
                ->where('approval_id', '=', $approval_id)
                ->update(['approval_status' => "2", 'note' => $note]);
            if (!$result) {
                throw new Exception("Nothing Change");
            }
            //jika berhasil return 1
            return '1';
        } catch (Exception $ex) {
            //jika gagal return pesan gagal
            return $ex->getMessage();
        }
    }

    /*
    updateToExpired()
    merubah status approval menjadi expired
     */
    public static function updateToExpired($account_id, $approval_id)
    {
        try {
            $result = Approvers::Distinct()
                ->where('account_id', '=', $account_id)
                ->where('approval_id', '=', $approval_id)
                ->update(['approval_status' => "4"]);
            if (!$result) {
                throw new Exception("Error Query");
            }
            //jika berhasil return 1
            return '1';
        } catch (Exception $ex) {
            //jika gagal return pesan gagal
            return $ex->getMessage();
        }
    }
}
