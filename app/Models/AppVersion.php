<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppVersion extends Model
{
    protected $table = 'app_version';

    public static function get_LatestAppVersion(){
        $app_version = AppVersion::select('version')
                        ->orderBy('created_at','desc')->first();

        return $app_version->version;
    }
}
