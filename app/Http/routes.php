<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
  'auth' => 'Auth\AuthController',
  'password' => 'Auth\PasswordController',
]);

Route::get('manage', 'ManagerController@index');
Route::get('manage/{id}/tasks', 'ManagerController@tasks');
Route::get('manage/{id}/timesheet', 'ManagerController@timesheet');
Route::get('manage/{id}/chart', 'ManagerController@chart');
Route::get('manage/{id}/feed', 'ManagerController@feed');