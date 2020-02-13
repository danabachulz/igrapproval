<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AppMessage;
use App\Models\FcmToken;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

// use to test uncheck function
class TestController extends Controller
{

    public function exe(){
        $job_level = 4;
        $branch_id = 1;
        $approval_status = \DB::table('approvers')
                                ->select('approvers.id','position.*')
                                ->join('accounts','approvers.account_id','accounts.id')
                                ->join('position','accounts.position_id','position.id')
                                //->where('approvers.approval_status',3)
                                ->where('position.job_level_id','<',$job_level)
                                ->where('accounts.branch_id',$branch_id)
                                ->get();

                                //tambah komen
                                //tambah lagi

        return response()->json([
            'api_status' => $approval_status
        ]);
    }
}
