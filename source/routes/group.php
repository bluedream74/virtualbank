<?php
/*
|--------------------------------------------------------------------------
| Group Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// group login
Route::group(['prefix' => 'login'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('group.showLoginForm');
    Route::post('/', 'Auth\LoginController@login')->name('group.login');
});

Route::group(['middleware' => 'auth:group'], function () {

    // login
    Route::get('', function () {
        return redirect('/group');
    });

    // logout
    Route::get('/dashboard', 'DashboardController@index')->name('group.index');

    // logout
    Route::get('/logout', 'Auth\LoginController@logout')->name('group.logout');

    // transaction
    Route::group(['prefix' => 'transaction'], function () {
        Route::get('/', 'TransactionController@index')->name('group.transaction.index');
        Route::post('/search', 'TransactionController@postSearch')->name('group.transaction.search');
        Route::get('/shop', 'TransactionController@getShopTransaction')->name('group.transaction.shop');
        Route::post('/shop', 'TransactionController@postShopSearch')->name('group.transaction.shop');
    });

    // shop
    Route::group(['prefix' => 'shop'], function () {
        Route::get('/', 'ShopController@index')->name('group.shop.index');
        Route::post('/search', 'ShopController@postSearch')->name('group.shop.search');
        Route::post('/switch', 'ShopController@postSwitch')->name('group.shop.switch');
        Route::post('/invoice', 'ShopController@postShowInvoice')->name('group.shop.invoice');
    });
});