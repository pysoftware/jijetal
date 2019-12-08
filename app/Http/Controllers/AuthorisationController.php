<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class AuthorisationController extends Controller
{
    public function getAuth(Request $request) {
        if (!empty(session()->get('login'))) {
            return redirect()->action('UserCabinetController@cabinet');
        }
        return view(
            'auth.authorisation'
        );
    }

    public function postAuth(Request $request) {
        $this->validate($request, [
            'login' => 'required|max:255',
            'password' => 'required',
        ]);
        $login = htmlspecialchars($request->login);
        $password = hash('md5', $request->password);
        if (!Users::validateUser($login, $password)) {
            return Response::json(array('errors' => array('validation' => 'Wrong login or password')), 422);
        }
        Session::put('login', $login);
        return URL::route('cabinet');
    }
}
