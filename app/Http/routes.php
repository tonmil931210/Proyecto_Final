<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
#header('Access-Control-Allow-Origin: *');
#header('Access-Control-Allow-Headers: Content-Type, Accept');
#header('Access-Control-Exposed-Headers: *');
#header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');



Route::group(['prefix' => 'api/v1', 'namespace' => 'api\v1', 'middleware' => 'cors'], function(){
	Route::resource('users', 'UsersController');
	Route::resource('events', 'EventsController');
	Route::resource('orders', 'OrdersController');
	Route::resource('orderStatus', 'OrderStatusController');
	Route::resource('itemsType', 'ItemsTypeController');
	Route::resource('items', 'ItemsController');
	Route::get('/', 'TestsController@index');
	Route::post('/login', 'SessionsController@login');
	Route::delete('/logout', 'SessionsController@logout');
	Route::post('orders/search', 'OrdersController@searchStatusOrder');
	Route::post('orders/{orders}/aprobar', 'OrdersController@aprobar');
	Route::post('orders/{orders}/entregar', 'OrdersController@entregar');
	Route::post('orders/{orders}/cancelar', 'OrdersController@cancelar');
	Route::post('orders/{orders}/rechazar', 'OrdersController@rechazar');
	Route::post('orders/{orders}/pendiente', 'OrdersController@pendiente');
	Route::post('items/{items}/recarga', 'ReloadsController@recarga');
	Route::post('orders/{orders}/devolucion', 'DevolutionsController@devolucion');
	Route::post('orders/{orders}/devolucionTodo', 'DevolutionsController@devolucion_todo');
	Route::get('devoluciones', 'DevolutionsController@index');
	Route::get('historic', 'HistoricController@index');
	Route::post('historic/search', 'HistoricController@search');
});

