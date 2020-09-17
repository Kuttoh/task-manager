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

Route::redirect('/', '/login');

Auth::routes(['verify' => true]);

Route::get('verify/resend', 'TwoFactorController@resend')->name('verify.resend');
Route::resource('verify', 'TwoFactorController')->only(['index', 'store']);

Route::group(['middleware' => ['auth', 'twofactor']
], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/users', 'UsersController@index')->name('users');
    Route::get('/users/{user}/edit', 'UsersController@edit');
    Route::post('/users/{user}/update', 'UsersController@update');
    Route::get('/users/{user}/makeAdmin', 'UsersController@makeAdmin');
    Route::get('/users/{user}/makeUser', 'UsersController@makeUser');
});
