<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use Illuminate\Http\Response;

Route::post('reg', 'RegistrationController@postRegister')->name('reg');

Route::post('auth', 'AuthorisationController@postAuth')->name('auth');

Route::post('edit', 'UserEditController@postSelfedit')->name('selfedit');

Route::post('edit/{id}', 'UserEditController@postEdit')
    ->where('id', '[0-9]+')
    ->name('edit');

Route::get('authorisation', 'AuthorisationController@getAuth');

Route::get('registration', 'RegistrationController@getRegister');

Route::get('cabinet', 'UserCabinetController@cabinet')->name('cabinet');

Route::get('logout', function (Request $request) {
    $request->session()->forget('login');
    return redirect('authorisation');
});

Route::get('edit', 'UserEditController@selfedit')->name('selfedit');

Route::get('edit/{id}', 'UserEditController@edit')
    ->where('id', '[0-9]+')
    ->name('edit');

Route::post('delete/{id}', 'UserEditController@delete')
    ->where('id', '[0-9]+')
    ->name('delete');


