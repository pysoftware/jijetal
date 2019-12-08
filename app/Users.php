<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    public $timestamps = false;

    public static function validateUser($login, $password)
    {
        $user = Users::where('login', '=', $login)
            ->where('password', '=', $password)
            ->get()
            ->toArray();
        if (count($user) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkIfExists($login)
    {
        $user = Users::where('login', '=', $login)->get()->toArray();
        if (!empty($user)) {
            return true;
        } else {
            return false;
        }
    }

}
