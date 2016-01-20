<?php

Route::group(['middleware' => ['web']], function () {
  Route::get('/', 'DashboardController@index')->name('dashboard');

  Route::group(['prefix' => 'manage'], function () {
    Route::get('/', 'ManagerController@index')->name('manager');
    Route::get('projects', 'ManagerController@projects')->name('manager.projects');
    Route::get('{project}/tasks', 'ManagerController@tasks')->name('manager.tasks');
    Route::get('{project}/tasks/create', 'ManagerController@create')->name('manager.tasks.create');
    Route::get('{project}/tasks/{task}/edit', 'ManagerController@edit')->name('manager.tasks.edit');
    Route::post('{project}/tasks', 'ManagerController@store')->name('manager.tasks.store');
    Route::post('{project}/tasks/{task?}', 'ManagerController@store')->name('manager.tasks.store');
    Route::put('tasks/{id}', 'ManagerController@update')->name('manager.tasks.update');
    Route::post('tasks/{id}/comment', 'ManagerController@comment ')->name('manager.tasks.comment');
    Route::put('tasks/{id}/move', 'ManagerController@move')->name('manager.tasks.move');
    Route::delete('tasks/{id}', 'ManagerController@delete')->name('manager.tasks.delete');

    Route::get('{id}/timesheet', 'ManagerController@timesheet')->name('manager.timesheet');
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