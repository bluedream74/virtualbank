<?php

//for login
Route::group(['prefix' => 'login'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('admin.showLoginForm');
    Route::post('/', 'Auth\LoginController@login')->name('admin.login');
});

//for forgot password
Route::group(['prefix' => 'password'], function () {
    Route::get('/forgot', 'Auth\ForgotPasswordController@showForgotPassForm')->name('password.request');
    Route::post('/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
});

Route::group(['middleware' => 'auth:admin'], function () {

    // login
    Route::get('', function () {
        return redirect('/admin');
    });

    // logout
    Route::get('logout', 'Auth\LoginController@logout')->name('admin.logout');

    // home
    Route::get('/', 'HomeController@index')->name('admin.home.index');

    // user
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index')->name('admin.user.index');
        Route::get('/create', 'UserController@showCreateForm')->name('admin.user.create');
        Route::post('/create', 'UserController@postCreate')->name('admin.user.create');
        Route::get('/edit/{id}', 'UserController@showEditForm')->name('admin.user.edit');
        Route::get('/shops/{id}', 'UserController@showShops')->name('admin.user.shops');

        Route::post('/edit', 'UserController@postEdit')->name('admin.user.edit');
        Route::get('/thanks', 'UserController@showThanks')->name('admin.user.thanks');
        Route::get('/delete/{id}', 'UserController@getDelete')->name('admin.user.delete');
        Route::get('/search', 'UserController@search')->name('admin.user.search');
        Route::post('/search', 'UserController@postSearch')->name('admin.user.search');

        Route::post('/qrcode', 'UserController@saveQRCode')->name('admin.user.qrcode');
    });

    // shop
    Route::group(['prefix' => 'shop'], function () {
        Route::get('/', 'ShopController@index')->name('admin.shop.index');
        Route::get('/create', 'ShopController@showCreateForm')->name('admin.shop.create');
        Route::post('/create', 'ShopController@postCreate')->name('admin.shop.create');
        Route::get('/edit/{id}', 'ShopController@showEditForm')->name('admin.shop.edit');
        Route::post('/edit', 'ShopController@postEdit')->name('admin.shop.edit');
        Route::get('/thanks', 'ShopController@showThanks')->name('admin.shop.thanks');
        Route::get('/delete/{id}', 'ShopController@getDelete')->name('admin.shop.delete');
        Route::get('/search', 'ShopController@search')->name('admin.shop.search');
        Route::post('/search', 'ShopController@postSearch')->name('admin.shop.search');

        Route::post('/qrcode', 'ShopController@saveQRCode')->name('admin.shop.qrcode');
    });

    // transaction
    Route::group(['prefix' => 'transaction'], function () {
        Route::get('/', 'TransactionController@index')->name('admin.transaction.index');
        Route::post('/search', 'TransactionController@postSearch')->name('admin.transaction.search');
        Route::post('/create', 'TransactionController@postCreate')->name('admin.transaction.create');
        Route::post('/delete', 'TransactionController@postDelete')->name('admin.transaction.delete');
    });

    // profile edit
    Route::get('/profile/edit', 'ProfileController@showEdit')->name('admin.profile.edit');
    Route::post('/profile/edit', 'ProfileController@postEdit')->name('admin.profile.edit');

    // invoice
    Route::group(['prefix' => 'invoice'], function () {
        Route::get('/', 'InvoiceController@index')->name('admin.invoice.index');
        Route::post('/search', 'InvoiceController@postSearch')->name('admin.invoice.search');
        Route::get('/csv', 'InvoiceController@showCSV')->name('admin.invoice.csv');
        Route::get('/detail/{id}', 'InvoiceController@getDetail')->name('admin.invoice.detail');
        Route::post('/search-csv', 'InvoiceController@postSearchCSV')->name('admin.invoice.search-csv');
    });
});

