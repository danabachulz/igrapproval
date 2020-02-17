<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'position';

    public static function get_PositionDetails($position_id){
        $approval_status = Position::Select('*')
                            ->where('id',$position_id)
                            ->first();
        return $approval_status;
    }

    public static function get_JobLevel($position_id){
        $position = self::get_PositionDetails($position_id);
        return $position->job_level_id;
    }

}
