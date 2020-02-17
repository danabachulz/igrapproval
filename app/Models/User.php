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
            ->where('phone_number', $phone_number)->get();

        if ($id->isEmpty()) {
            return [];
        }

        if (Hash::check($pin, $id[0]->pin)) {
            return $id[0]->id;
        } else {
            return [];
        }

    }

    public static function get_AccountInfo($id = "%")
    {
        $user = User::Distinct()
            ->select('*')
            ->Where('id', $id)
            ->get();

        return $user[0];
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
