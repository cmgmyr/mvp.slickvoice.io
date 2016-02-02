<?php

Route::group(['middleware' => 'web'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('soon', ['as' => 'soon', 'uses' => 'HomeController@soon']);

    Route::group(['middleware' => 'auth'], function () {
        Route::group(['prefix' => 'clients'], function () {
            Route::get('/', ['as' => 'clients.index', 'uses' => 'ClientsController@index']);
            Route::get('create', ['as' => 'clients.create', 'uses' => 'ClientsController@create']);
            Route::get('import', ['as' => 'clients.import', 'uses' => 'ClientsController@import']);
            Route::post('/', ['as' => 'clients.store', 'uses' => 'ClientsController@store']);
            Route::get('{id}/edit', ['as' => 'clients.edit', 'uses' => 'ClientsController@edit']);
            Route::put('{id}', ['as' => 'clients.update', 'uses' => 'ClientsController@update']);
            Route::get('{id}/card', ['as' => 'clients.card-edit', 'uses' => 'ClientsController@editCard']);
            Route::put('{id}/card', ['as' => 'clients.card-update', 'uses' => 'ClientsController@updateCard']);
            Route::delete('{id}', ['as' => 'clients.destroy', 'uses' => 'ClientsController@destroy']);
        });

        Route::group(['prefix' => 'invoices'], function () {
            Route::get('/', ['as' => 'invoices.index', 'uses' => 'InvoicesController@index']);
            Route::get('create', ['as' => 'invoices.create', 'uses' => 'InvoicesController@create']);
            Route::post('/', ['as' => 'invoices.store', 'uses' => 'InvoicesController@store']);
            Route::get('{uuid}', ['as' => 'invoices.show', 'uses' => 'InvoicesController@show']);
            Route::get('{uuid}/edit', ['as' => 'invoices.edit', 'uses' => 'InvoicesController@edit']);
            Route::get('{uuid}/refresh', ['as' => 'invoices.refresh', 'uses' => 'InvoicesController@refresh']);
            Route::put('{uuid}', ['as' => 'invoices.update', 'uses' => 'InvoicesController@update']);
            Route::delete('{uuid}', ['as' => 'invoices.destroy', 'uses' => 'InvoicesController@destroy']);

            Route::get('items/create', ['as' => 'invoices.items.create', 'uses' => 'InvoicesController@itemCreate']);
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
