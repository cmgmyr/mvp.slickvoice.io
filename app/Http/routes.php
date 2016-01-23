<?php

Route::group(['middleware' => 'web'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('soon', ['as' => 'soon', 'uses' => 'HomeController@soon']);

    Route::group(['prefix' => 'clients'], function() {
        Route::get('/', ['as' => 'clients.index', 'uses' => 'ClientController@index']);
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
