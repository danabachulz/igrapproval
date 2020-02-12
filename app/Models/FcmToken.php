<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{

    // fcm fun
    public static function get_fcm_count($id,$fcm_token){
        return $fcm_counter = \DB::table('fcm')->select('id')
                            ->where('user_id',$id)
                            ->where('fcm',$fcm_token)->count();
    }

    public static function set_fcm_token($id,$fcm_token){
        return $fcm_save = \DB::table('fcm')->insertGetId(
            ['member_id'=> $id,'fcm' =>$fcm_token]);
    }
}
