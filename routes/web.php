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

// Route::get('/', function () {
//     return view('welcome');
// });


	Route::get('/','IndexController@index');
	Route::get('/login','IoginController@login');
	Route::get('/loginaout','IoginController@loginaout');
	Route::get('/reg','IoginController@reg');
	Route::get('/proinfo','IndexController@proinfo');
	Route::get('/okby','IndexController@okby');
	Route::post('/send','IoginController@send');
	Route::post('/send2','IoginController@send2');
	Route::post('/reg_do','IoginController@reg_do');
	Route::post('/login_do','IoginController@login_do');
	Route::post('/like','LikeController@index');
	Route::get('/shoucang','LikeController@shoucang');
	Route::post('/addcart','CartController@addcart');
	Route::get('/cartList','CartController@index');
	Route::get('/pay','CartController@pay');
	Route::get('/ok123','CartController@ok123');
	Route::get('/adress','AdressController@index');
	Route::post('/getarea','AdressController@getarea');
	Route::post('/address_add','AdressController@address_add');
	Route::get('/add_address','AdressController@add_address');
	Route::post('/countTotal','AdressController@countTotal');
	Route::post('/changeBuyNumber','AdressController@changeBuyNumber');
	Route::get('/youhui','DiscountController@index');

	Route::get('/test','testController@index');
	Route::get('/ok','AdressController@ok');
	Route::post('/okyes','AdressController@okyes');
	Route::get('/user','IndexController@user');
	Route::get('/success','AdressController@success');
	Route::get('/successok','AdressController@successok');
	Route::post('/is_login','IsController@login');