<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::get('manage', 'ManagerController@index');
Route::get('manage/{id}/tasks', 'ManagerController@tasks');
Route::get('manage/{id}/timesheet', 'ManagerController@timesheet');
Route::get('manage/{id}/chart', 'ManagerController@chart');
Route::get('manage/{id}/feed', 'ManagerController@feed');

Route::group(['middleware' => ['web']], function () {
    //
});
