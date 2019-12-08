<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    public function index($name) {
        return view(
            'auth.authorisation',
            [
                'name'=> $name
            ]
        );
    }
}
