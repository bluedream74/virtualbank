<?php
/*
|--------------------------------------------------------------------------
| Merchant Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// merchant login
Route::group(['prefix' => 'login'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('merchant.showLoginForm');
    Route::post('/', 'Auth\LoginController@login')->name('merchant.login');
});

Route::group(['middleware' => 'auth:merchant'], function () {

    // login
    Route::get('', function () {
        return redirect('/merchant');
    });

    // logout
    Route::get('/dashboard', 'DashboardController@index')->name('merchant.index');

    // logout
    Route::get('/logout', 'Auth\LoginController@logout')->name('merchant.logout');

    // qr
    Route::group(['prefix' => 'qr-payment'], function () {
        Route::get('/', 'QRPaymentController@index')->name('merchant.qr.index');
        Route::get('/edit', 'QRPaymentController@showEdit')->name('merchant.qr.edit');
    });

    // SMS
    Route::group(['prefix' => 'sms-payment'], function () {
        Route::get('/', 'SmsPaymentController@index')->name('merchant.sms.index');
        Route::post('/thanks', 'SmsPaymentController@postCreate')->name('merchant.sms.thanks');
    });

    // transaction
    Route::group(['prefix' => 'transaction'], function () {
        Route::get('/', 'TransactionController@index')->name('merchant.transaction.index');
        Route::post('/search', 'TransactionController@postSearch')->name('merchant.transaction.search');
        Route::get('/shop', 'TransactionController@getShopTransaction')->name('merchant.transaction.shop');
        Route::post('/shop', 'TransactionController@postShopSearch')->name('merchant.transaction.shop');
    });

    Route::group(['prefix' => 'fee-setting'], function () {
        Route::get('/', 'FeeController@index')->name('merchant.fee.index');
        Route::get('/edit', 'FeeController@showEdit')->name('merchant.fee.edit');
        Route::post('/edit', 'FeeController@postEdit')->name('merchant.fee.edit');
    });

    Route::group(['prefix' => 'payment'], function () {
        Route::get('/', 'PaymentController@index')->name('merchant.payment.index');
    });

    Route::group(['prefix' => 'invoice'], function () {
        Route::get('/', 'InvoiceController@index')->name('merchant.invoice.index');
    });

});