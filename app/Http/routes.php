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
<<<<<<< HEAD
  'auth' => 'Auth\AuthController',
  'password' => 'Auth\PasswordController',
]);

Route::get('manage', 'ManagerController@index');
=======
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
>>>>>>> 4e5bb1960842a3432876771d736fe7dfd1062934
