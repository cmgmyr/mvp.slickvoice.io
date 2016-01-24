<?php

Route::group(['middleware' => 'web'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('soon', ['as' => 'soon', 'uses' => 'HomeController@soon']);

    Route::group(['middleware' => 'auth'], function () {
        Route::group(['prefix' => 'clients'], function () {
            Route::get('/', ['as' => 'clients.index', 'uses' => 'ClientController@index']);
            Route::get('create', ['as' => 'clients.create', 'uses' => 'ClientController@create']);
            Route::get('import', ['as' => 'clients.import', 'uses' => 'ClientController@import']);
            Route::post('/', ['as' => 'clients.store', 'uses' => 'ClientController@store']);
            Route::get('{id}', ['as' => 'clients.show', 'uses' => 'ClientController@show']);
            Route::get('{id}/edit', ['as' => 'clients.edit', 'uses' => 'ClientController@edit']);
            Route::put('{id}', ['as' => 'clients.update', 'uses' => 'ClientController@update']);
            Route::delete('{id}', ['as' => 'clients.destroy', 'uses' => 'ClientController@destroy']);
        });
    });

    // Authentication Routes...
    $this->get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@showLoginForm']);
    $this->post('login', 'Auth\AuthController@login');
    $this->get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);

    // Password Reset Routes...
    $this->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    $this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $this->post('password/reset', 'Auth\PasswordController@reset');
});

Route::macro('after', function ($callback) {
    $this->events->listen('router.filter:after:newrelic-patch', $callback);
});
