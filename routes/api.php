<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    dd($request->user());
});



// Route::group(['prefix' => 'v1'], function(){
// 	Route::group(['prefix' => 'users'], function(){
// 		Route::get('', 'UserController@getData');
//     });

// 	// Route::group(['prefix' => 'tasks'], function(){
// 	// 	Route::post('aprove/{id}', 'TaskController@aprove');
// 	// 	Route::post('cancel/{id}', 'TaskController@cancel');
// 	// });
// });

// Route::group(['prefix' => 'v1'], function(){
// 	// Route::group(['prefix' => 'tasks'], function(){
// 	// 	Route::post('aprove/{id}', 'TaskController@aprove');
// 	// 	Route::post('cancel/{id}', 'TaskController@cancel');
// 	// });
// });

// Route::group(['prefix' => 'seminar'], function(){
//     Route::get('', 'APIController@getData');
//     Route::post('', 'APIController@fetchData');
// });
