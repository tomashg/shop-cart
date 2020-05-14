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

use App\Mail\OrderMail;

Route::get('/send-mail', function() {
    return new OrderMail();
});
Route::get('/', 'ProductsController@index');
Route::get('/add-to-cart/{id}', [
    'uses' => 'ProductsController@addProductToCart',
    'as' => 'products.addProductToCart'
]);
Route::get('/my-shopping-cart', [
    'uses' => 'ProductsController@getCart',
    'as' => 'products.getCart'
]);
Route::get('/delete-from-cart/{id}', [
    'uses' => 'ProductsController@deleteFromCart',
    'as' => 'products.deleteFromCart'
]);
Route::post('/order', [
    'uses' => 'ProductsController@getOrder',
    'as' => 'products.getOrder'
]);
Auth::routes();
Route::resource('products','ProductsController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
