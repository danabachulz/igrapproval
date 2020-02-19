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
        $tomorrow = date('Y-m-d', strtotime('tomorrow')).' '.date('H:i:s');
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjY5YWM5ZDYzMGU5ZjJlOTNiOTk2NzllYjYwODc5YTBlY2E4ZTBlYjBhNDkyZGQ3NzBjNmRkOWUwNGEwMWQxZjZkNDEwZWY2MWU1OTAyYmRiIn0.eyJhdWQiOiI0IiwianRpIjoiNjlhYzlkNjMwZTlmMmU5M2I5OTY3OWViNjA4NzlhMGVjYThlMGViMGE0OTJkZDc3MGM2ZGQ5ZTA0YTAxZDFmNmQ0MTBlZjYxZTU5MDJiZGIiLCJpYXQiOjE1ODIwOTYyMjUsIm5iZiI6MTU4MjA5NjIyNSwiZXhwIjoxNjEzNzE4NjI1LCJzdWIiOiI4Iiwic2NvcGVzIjpbXX0.V7Gtw0n0cZHy2kYH7LqxQk2VRdyPA2J_0cZERDWjBySjx87XIkgi1S0QGPnBuP21cOEL_2-1O57x6bJMvGD4s2glP4sBmCcfYXNs21jV_xsmX_5kT1bCRtZeT_ZBRt-0vlZ7XpqmooHRhuVsIOoQvOyoCh2-gjsctzitM_3d7vj9O9-eU1HCMDRNi6C8zCzTEwN71XXgSoakVEphkZIo2ZJOIpEu0FVUOcyW6pZn8wzRI19O-fNprjE1X5DNg2kjR19_O8DsgPlxBaoPBxogjoGyY7tstyZAXJBj8sVejQiTi0pdLzEIL2Yw7LRWLv271jsYvEvTK9V6JYMaZ0qkoiHxadIw1iOD1o3o607VSqMLYjgHF5r5Yx5_yLFrNmsePWGuVmCm3BzqJahniC4BZdfNOm2b1bk19HJI_xpd_W4zZ97yHGPcLD4WHu8ZIc_atRHNPD1u0g1CljVdqXz53O3a0rQ_tLQnyFa6ZG_dB2o5ox3Q1aHlkYyUAMSDmB6ASBCJoT2fTUNrFIOkWdMpVdBrHDeQWezhhPYaTbA0Ck_MfBeWwrz5sbKVIDor8EmOaDE4sBzmJjXjbtBe5aMtrg1UoKIM42UxA8_xb4J31fM5R08iCk3a8ag_ugup1J1lb82bCGq2s5IdPGawMmtgqBffZoZOSvk5OzSb_PcZQZM';
        $count = User::check_AccessToken($access_token);

        return response()->json([
            $count
        ]);
    }
}
