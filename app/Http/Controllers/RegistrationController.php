<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class RegistrationController extends Controller
{
    public function getRegister()
    {
        return view(
            'auth.registration'
        );
    }

    public function postRegister(Request $request)
    {
        if ($request->input('password1') !== $request->input('password2')) {
            return Response::json(array('errors' => array('password' => 'Passwords must be match')), 422);
        }
        $this->validate($request, [
            'login' => 'required|max:255|unique:users',
            'password1' => 'required',
            'password2' => 'required',
        ]);
        $login = htmlspecialchars($request->login);
        $password = hash('md5', $request->password1);
        $user = new Users();
        $user->login = $login;
        $user->password = $password;
        $user->save();
        Session::put('login', $login);
        return URL::route('cabinet');
    }
}
