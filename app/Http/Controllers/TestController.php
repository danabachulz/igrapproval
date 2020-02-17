<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Approval;
use App\Models\AppMessage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

// use to test uncheck function
class TestController extends Controller
{

    public function exe(){

        return response()->json([
            date('Y-m-d H:i:s')
        ]);
    }
}
