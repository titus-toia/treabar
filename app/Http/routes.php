<?php

Route::group(['middleware' => ['web']], function () {
  Route::get('/', 'DashboardController@index')->name('dashboard');

  Route::group(['prefix' => 'manage'], function () {
    Route::get('/', 'ManagerController@index')->name('manager');
    Route::get('projects', 'ManagerController@projects')->name('manager.projects');
    Route::get('{project}/tasks', 'ManagerController@tasks')->name('manager.tasks');
    Route::get('{project}/tasks/create', 'ManagerController@createTask')->name('manager.tasks.create');
    Route::get('{project}/tasks/{task}/edit', 'ManagerController@editTask')->name('manager.tasks.edit');
    Route::get('tasks/{task}/comments', 'ManagerController@comments')->name('manager.tasks.comments');
    Route::post('{project}/tasks', 'ManagerController@storeTask')->name('manager.tasks.store');
    Route::post('tasks/{task}/comment', 'ManagerController@comment')->name('manager.tasks.comment');
    Route::put('tasks/{task}', 'ManagerController@updateTask')->name('manager.tasks.update');
    Route::put('tasks/{task}/move', 'ManagerController@move')->name('manager.tasks.move');
    Route::delete('tasks/{task}', 'ManagerController@deleteTask')->name('manager.tasks.delete');

    Route::get('{project}/timesheet', 'ManagerController@timesheet')->name('manager.timesheet');
    Route::post('{project}/timesheet', 'ManagerController@storeActivity')->name('manager.timesheet.store');
    Route::put('{project}/timesheet/{activity}', 'ManagerController@updateActivity')->name('manager.timesheet.update');

    Route::get('{id}/chart', 'ManagerController@chart')->name('manager.chart');
    Route::get('{id}/feed', 'ManagerController@feed')->name('manager.feed');

  });

  Route::group(['prefix' => 'invoice'], function () {
    Route::get('/', 'InvoiceController@index')->name('invoices');
  });
});

Route::get('test', function() {
  return View::make('test');
});