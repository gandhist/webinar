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

Route::get('infoseminar','InfoSeminarController@index');
Route::get('infoseminar/detail/{id}','InfoSeminarController@detail');
Route::get('registrasi','RegistController@index');
Route::post('registrasi/store','RegistController@store');

Route::get('sertifikat/cari','SertController@cari')->name('cari');
Route::get('sertifikat/{no_sert}/{email}','SertController@by_sert');
Route::get('sertifikat_v1/{no_sert}/{email}','SertController@sert_v1');
Route::get('sertifikat_v2/{no_sert}/{email}','SertController@sert_v2');
Route::get('approved/adji','SertController@ttd1');
Route::get('approved/iman','SertController@ttd2');
Route::get('approved/budi_susetyo','SertController@ttd3');
Route::get('approved/adji_n','SertController@ttd4');
Route::get('approved/viby','SertController@ttd_viby');
Route::get('approved/irwin','SertController@ttd_irwin');
Route::get('p3sm','SertController@p3sm');

Route::namespace('Laporan')->group(function(){
	Route::post('laporan/chain','LaporanController@chained_prov')->name('chained_prov');
	Route::resource('laporan','LaporanController');
	Route::get('laporan/chained_scope/{id}','LaporanController@chained_scope');
	Route::get('laporan/print/{id}','LaporanController@print');
});

Route::namespace('Iso')->group(function(){
	Route::get('iso/print/{id}', 'IsoController@print');
});

Route::auth();

Route::group(['middleware' => 'auth'], function () {
Route::get('sertifikat','SertController@dashboard')->name('sertifikat');
Route::get('kirim_email','SertController@kirimEmail');
Route::get('send_email/{id}','SertController@sendEmail');

// Seminar

// Route::group(['prefix' => 'seminar'], function () {
// 	Route::get('/','SeminarController@index');
// 	Route::get('create','SeminarController@create');
// 	Route::post('store','SeminarController@store');
// 	Route::get('detail/{id}','SeminarController@detail');
// 	Route::get('sertifikat/{no_sert}/{email}','SeminarController@detail');
// });

// Route::group(['prefix' => 'temp'], function () {
// 	Route::get('/','SeminarController2@index');
// 	Route::get('create','SeminarController2@create');
// 	Route::post('store','SeminarController2@store');
// 	Route::get('detail/{id}','SeminarController2@detail');
// 	Route::get('sertifikat/{no_sert}/{email}','SeminarController2@detail');
// });

Route::group(['middleware' => 'auth.admin','prefix' => 'seminar'], function () {
	Route::get('/', 'SeminarController@index');

});

// End Seminar

Route::namespace('Iso')->group(function(){
	Route::post('iso/destroy', 'IsoController@destroy');
	Route::resource('isos', 'IsoController');
});

// Personal 
Route::group(['middleware' => 'auth.admin','prefix' => 'personals'], function () {
	Route::get('/','PersonalController@index');
	Route::get('/create','PersonalController@create');
	Route::post('/store','PersonalController@store');
	Route::patch('/update','PersonalController@update');
	Route::get('/create/getKota/{id}','PersonalController@getKota');
	Route::get('/{id}/edit','PersonalController@edit');
    Route::get('/{id}','PersonalController@show');
	Route::delete('/destroy', 'PersonalController@destroy');
});
// End Personal

// Peserta
Route::group(['middleware' => 'auth.admin', 'prefix' => 'pesertas'], function () {
	Route::get('/','PesertaController@index');
    Route::get('/{id}','PesertaController@show');
	Route::patch('/update','PesertaController@update');
	Route::get('/create/getKota/{id}','PesertaController@getKota');
	Route::get('/{id}/edit','PesertaController@edit');
	
});
// End Peserta

// Instansi 
Route::group(['middleware' => 'auth.admin','prefix' => 'instansi'], function () {
	Route::get('/','InstansiController@index');
	Route::get('/create','InstansiController@create');
	Route::post('/store','InstansiController@store');
	Route::patch('/update','InstansiController@update');
	Route::get('/create/getKota/{id}','InstansiController@getKota');
	Route::get('/{id}/edit','InstansiController@edit');
    Route::get('/{id}','InstansiController@show');
	Route::delete('/destroy','InstansiController@destroy');
});
// End Instansi


Route::group(['middleware' => 'auth'], function () {
	Route::get('profile', 'ProfileController@edit')->name('profile.edit');
	Route::post('profile', 'ProfileController@update')->name('profile.update');
	Route::get('changepassword', 'ProfileController@changePassword')->name('profile.change');
	Route::post('savepassword', 'ProfileController@savePassword')->name('changepassword');

	
});


	Route::group(['middleware' => 'auth.input'], function () {
		Route::get('', 'HomeController@index');
	});

	Route::group(['middleware' => 'auth.admin'], function () {
		Route::resources([
			'users' => 'UserController',
		]);
		Route::resources([
			'user_role' => 'UserRoleController',
		]);
	});
});










// Report

Route::group(['prefix' => 'report'], function () {

});


// end of Report
