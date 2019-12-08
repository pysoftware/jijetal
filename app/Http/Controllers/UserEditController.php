<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class UserEditController extends Controller
{
    public function edit(Request $request, $id)
    {
        if (empty(session()->get('login'))) {
            return redirect()->action('AuthorisationController@getAuth');
        }
        $editableUser = Users::find($id)->toArray();

        return view(
            'user.edit',
            [
                'login' => $editableUser['login'],
                'url' => $request->path()
            ]
        );
    }

    public function postEdit(Request $request, $id) {
        if (empty(session()->get('login'))) {
            return redirect()->action('AuthorisationController@getAuth');
        }
        $this->validate($request, [
            'login' => 'unique:users|required',
            'password' => 'required'
        ]);
        $login = htmlspecialchars($request->login);
        $password = hash('md5', $request->password);
        $user = Users::find($id);
        $user->login = $login;
        $user->password = $password;
        $user->save();
        return URL::route('cabinet');
    }

    public function selfedit(Request $request)
    {
        if (empty(session()->get('login'))) {
            return redirect()->action('AuthorisationController@getAuth');
        }
        $user = Users::where('login', '=', session('login'))->get()->toArray()[0];
        return view(
            'user.edit',
            [
                'login' => $user['login'],
                'url' => $request->path()
            ]
        );
    }

    public function postSelfedit(Request $request) {
        if (empty(session()->get('login'))) {
            return redirect()->action('AuthorisationController@getAuth');
        }
        $this->validate($request, [
            'login' => 'unique:users|required',
            'password' => 'required'
        ]);
        $login = htmlspecialchars($request->login);
        $password = hash('md5', $request->password);
        $user = Users::where('login', '=', session('login'))->first();
        $user->login = $login;
        $user->password = $password;
        $user->save();
        Session::put('login', $login);
        return URL::route('cabinet');
    }

    public function delete($id) {
        $user = Users::find($id);
        $user->delete();
        return URL::route('cabinet');
    }
}
