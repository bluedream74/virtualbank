<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// user login
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('customer.showLoginForm');
Route::post('/login', 'Auth\LoginController@login')->name('customer.login');

// payment
Route::group(['prefix' => 'payment'], function () {
    Route::get('/{path}', 'PaymentController@index')->name('customer.payment.index');
    Route::post('/confirm', 'PaymentController@confirm')->name('customer.payment.confirm');
    Route::post('/thanks', 'PaymentController@postCreate')->name('customer.payment.thanks');
});

// terms, privacy-policy
Route::get('/terms', 'TermsController@index')->name('customer.terms.index');
Route::get('/privacy-policy', 'PrivacyController@index')->name('customer.privacy.index');

Route::post('/mail', 'HomeController@mail')->name('customer.home.mail');
Route::post('/email', 'HomeController@email')->name('customer.home.email');

// auto invoice
Route::get('/invoice/auto', 'InvoiceController@autoInvoices')->name('customer.invoice.auto');
Route::get('/invoice/force/{month}', 'InvoiceController@forceInvoices')->name('customer.invoice.force');

Route::group(['middleware' => 'auth:web'], function () {

    // logout
    Route::get('/logout', 'Auth\LoginController@logout')->name('customer.logout');

    // home
    Route::get('/', 'HomeController@index')->name('customer.home.index');

    // SMS
    Route::group(['prefix' => 'sms-payment'], function () {
        Route::get('/', 'SmsPaymentController@index')->name('customer.sms.index');
        Route::post('/thanks', 'SmsPaymentController@postCreate')->name('customer.sms.thanks');
    });

    // transaction
    Route::group(['prefix' => 'transaction'], function () {
        Route::get('/', 'TransactionController@index')->name('customer.transaction.index');
        Route::get('/{id}', 'TransactionController@showDetail')->name('customer.transaction.detail');
        Route::post('/pagelen', 'TransactionController@postPageLen')->name('customer.transaction.page');
        Route::post('/search', 'TransactionController@postSearch')->name('customer.transaction.search');
    });

    Route::group(['prefix' => 'fee-setting'], function () {
        Route::get('/', 'FeeController@index')->name('customer.fee.index');
        Route::get('/edit', 'FeeController@showEdit')->name('customer.fee.edit');
        Route::post('/edit', 'FeeController@postEdit')->name('customer.fee.edit');
    });

    Route::group(['prefix' => 'invoice'], function () {
        Route::get('/{token}', 'InvoiceController@index')->name('customer.invoice.index');
        Route::post('/create', 'InvoiceController@postCreate')->name('customer.invoice.create');
        Route::post('/search', 'InvoiceController@postSearch')->name('customer.invoice.search');
        Route::get('/detail/{year}/{start}/{end}/{output_date}/{is_lastdate}', 'InvoiceController@getDetail')->name('customer.invoice.detail');
    });

});