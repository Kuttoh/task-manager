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
    Route::get('/home', 'ProjectsController@index')->name('home');

    Route::get('/users', 'UsersController@index')->name('users');
    Route::get('/users/{user}/edit', 'UsersController@edit');
    Route::post('/users/{user}/update', 'UsersController@update');
    Route::get('/users/{user}/makeAdmin', 'UsersController@makeAdmin');
    Route::get('/users/{user}/makeUser', 'UsersController@makeUser');

    Route::get('/projects', 'ProjectsController@index')->name('projects');
    Route::get('/projects/create', 'ProjectsController@create')->name('project.create');
    Route::post('/projects', 'ProjectsController@store')->name('project.store');

    Route::get('/projects/{project_id}/edit', 'ProjectsController@edit')->name('project.edit');
    Route::post('/projects/{project_id}/update', 'ProjectsController@update')->name('project.update');

    Route::get('/projects/{project_id}/delete', 'ProjectsController@destroy')->name('project.delete');
    Route::get('/projects/{project_id}', 'ProjectsController@show')->name('project.show');


    Route::get('/tasks/create', 'TaskController@create')->name('task.create');
});
