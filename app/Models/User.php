<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'accounts';

    public static function get_AccountID($phone_number, $pin)
    {
        $id = User::Distinct()
            ->select('id', 'pin')
            ->where('phone_number', $phone_number)->first();

        if (empty($id)) {
            return [];
        }

        if (Hash::check($pin, $id->pin)) {
            return $id->id;
        } else {
            return [];
        }

    }

    public static function get_AccountInfo($id = "%")
    {
        $user = User::Distinct()
            ->select('accounts.*','position.description AS position_desc')
            ->join('position','accounts.position_id','position.id')
            ->Where('accounts.id', $id)
            ->first();

        // convert to string
        $user->position_id = (string) $user->position_id;
        $user->branch_id = (string) $user->branch_id;
        return $user;
    }

    public static function get_AccountById($id)
    {
        $user = User::Distinct()
            ->select('*')
            ->Where('id', '=', $id)
            ->first()
            ->get();

        return $user;
    }

    public static function save_AccessToken($account_id,$access_token){
        //create expired time
        $tomorrow = date('Y-m-d', strtotime('tomorrow')).' '.date('H:i:s');
        //save token
        $user = User::Distinct()
                ->where('id', $account_id)
                ->update(['remember_token' => $access_token, 'token_expired'=>$tomorrow]);

        return 1;
    }

    public static function check_AccessToken($access_token){
        //check if token still active
        $user_count = User::Distinct()
                    ->where('remember_token', $access_token)
                    ->where('token_expired','>',date('Y-m-d H:i:s'))->count();

        //return 1 if active
        return $user_count;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'pin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
