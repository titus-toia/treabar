<?php

use Illuminate\Support\Facades\Input;

Route::group(['middleware' => ['web']], function () {
  Route::get('/', 'DashboardController@index')->name('dashboard');
  Route::post('state', function() {
    $state = Input::get('state');
    \Session::put('state', $state);
  });

  Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', 'DashboardController@index');
    Route::get('discussion/feed', 'DashboardController@discussionFeed')->name('dashboard.discussion.feed');
    Route::get('activity/feed', 'DashboardController@activityFeed')->name('dashboard.activity.feed');
  });

  Route::group(['prefix' => 'manage'], function () {
    Route::get('/', 'ManagerController@index')->name('manager');
    Route::get('projects', 'ManagerController@projects')->name('manager.projects');

    Route::get('projects/create', 'ManagerController@createProject')->name('manager.projects.create');
    Route::post('projects', 'ManagerController@storeProject')->name('manager.projects.store');
    Route::post('projects/{project}/edit', 'ManagerController@editProject')->name('manager.projects.edit');
    Route::post('projects/{project}/update', 'ManagerController@updateProject')->name('manager.projects.update');

    Route::get('{project}/tasks', 'ManagerController@tasks')->name('manager.tasks');
    Route::get('{project}/tasks/create', 'ManagerController@createTask')->name('manager.tasks.create');
    Route::get('{project}/tasks/{task}/edit', 'ManagerController@editTask')->name('manager.tasks.edit');
    Route::get('{project}/tasks/{task}/invoice', 'ManagerController@invoiceTask')->name('manager.tasks.invoice');
    Route::get('tasks/{task}/comments', 'ManagerController@comments')->name('manager.tasks.comments');
    Route::post('{project}/tasks', 'ManagerController@storeTask')->name('manager.tasks.store');
    Route::post('tasks/{task}/comment', 'ManagerController@comment')->name('manager.tasks.comment');
    Route::put('tasks/{task}', 'ManagerController@updateTask')->name('manager.tasks.update');
    Route::put('tasks/{task}/move', 'ManagerController@moveTask')->name('manager.tasks.move');
    Route::put('tasks/{task}/complete', 'ManagerController@completeTask')->name('manager.tasks.complete');
    Route::delete('tasks/{task}', 'ManagerController@deleteTask')->name('manager.tasks.delete');

    Route::get('{project}/timesheet', 'ManagerController@timesheet')->name('manager.timesheet');
    Route::get('{project}/timesheet/create', 'ManagerController@createActivity')->name('manager.timesheet.create');
    Route::get('{project}/timesheet/{activity}/edit', 'ManagerController@editActivity')->name('manager.timesheet.edit');
    Route::post('{project}/timesheet', 'ManagerController@storeActivity')->name('manager.timesheet.store');
    Route::put('{project}/timesheet/{activity}', 'ManagerController@updateActivity')->name('manager.timesheet.update');
    Route::delete('timesheet/{activity}', 'ManagerController@deleteActivity')->name('manager.timesheet.delete');

    Route::get('{project}/chart', 'ManagerController@chart')->name('manager.chart');
    Route::get('{project}/feed', 'ManagerController@feed')->name('manager.feed');

  });

  Route::group(['prefix' => 'invoice'], function () {
    Route::get('/', 'InvoiceController@index')->name('invoices');
    Route::get('create/{task}', 'InvoiceController@create')->name('invoice.create');
    Route::post('/', 'InvoiceController@store')->name('invoice.store');
    Route::get('{invoice}', 'InvoiceController@edit')->name('invoice.edit');
    Route::put('{invoice}', 'InvoiceController@update')->name('invoice.update');
    Route::delete('{invoice}', 'InvoiceController@destroy')->name('invoice.delete');
  });

  Route::group(['prefix' => 'settings'], function() {
    Route::get('/', 'SettingsController@userSettings')->name('settings.user');
    Route::get('company', 'SettingsController@companySettings')->name('settings.company');
  });
});

Route::get('test', function() {
  echo 'test';
});