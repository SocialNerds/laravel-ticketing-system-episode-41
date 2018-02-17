<?php

Auth::routes();

Route::get('/', 'TicketsController@index')->name('home');

Route::group(
  ['middleware' => ['role:admin']],
  function () {
      Route::get('/users', 'UsersController@index');
      Route::get('/users/{id}', 'UsersController@edit');
      Route::patch('/users/{id}', 'UsersController@update');
  }
);


Route::get('/tickets/create', 'TicketsController@create');
Route::post('/tickets/save', 'TicketsController@save');

Route::group(
  ['middleware' => 'tickets'],
  function () {
      Route::get('/tickets/{id}/edit', 'TicketsController@edit');
      Route::patch('/tickets/{id}', 'TicketsController@update');
      Route::get('/ticket/{id}', 'TicketsController@ticket');
      Route::post('/comments/{id}', 'TicketsController@comment');
  }
);
