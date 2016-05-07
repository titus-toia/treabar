<?php

Route::group(['middleware' => ['web']], function () {
  Route::get('/', 'DashboardController@index')->name('dashboard');

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
  });
});

Route::get('test', function() {
  return \View::make('partials.scrollers.testScroll')->with('only_data', true);
});