<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCabinetController extends Controller
{
    public function cabinet(Request $request)
    {

        if (empty(session()->get('login'))) {
            return redirect()->action('AuthorisationController@getAuth');
        }
        $currentUser = Users::where('login', '=', session('login'))->first();
        if ($currentUser['group_id'] === 2) {
            return view(
                'user.cabinet'
            );
        } else {
            if (!empty($request->input('sort'))) {
                session()->put('sort', $request->input('sort') ?? 'asc');
            }
            if (!empty($request->input('findInput'))) {
                $pattern = $request->input('findInput');
                $users = DB::table('users')
                    ->where('group_id', '>', '1')
                    ->where('login', 'like', "%$pattern%")
                    ->orderBy('login', session('sort'))
                    ->paginate(20);
            } else {
                $users = DB::table('users')
                    ->where('group_id', '>', '1')
                    ->orderBy('login', session('sort'))
                    ->paginate(2);
            }
            return view(
                'user.cabinet', [
                    'users' => $users
                ]
            );
        }
    }
}
