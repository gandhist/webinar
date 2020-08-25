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
Route::auth();
Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('', 'FrontendController@index')->name('homeUI');
Route::get('/cari', 'FrontendController@loadData');
Route::get('reset', 'FrontendController@reset');
Route::post('reset/update', 'FrontendController@update');

Route::get('infoseminar','InfoSeminarController@index')->name('infoseminar');
Route::get('infoseminar/detail/{id}','InfoSeminarController@detail');
Route::get('infoseminar/daftar/{id}','InfoSeminarController@daftar');
Route::post('infoseminar/store/{id}','InfoSeminarController@store');
Route::get('kirimwa','SeminarController@kirimWA');

Route::get('registrasi','RegistController@index');
Route::post('registrasi/store','RegistController@store');
Route::get('registrasi/daftar/{id}','RegistController@daftar');
Route::post('registrasi/save/{id}','RegistController@save');

Route::get('profile', 'ProfileController@edit')->name('profile.edit');
Route::post('profile', 'ProfileController@update')->name('profile.update');
Route::get('changepassword', 'ProfileController@changePassword')->name('profile.change');
Route::post('savepassword', 'ProfileController@savePassword')->name('changepassword');
Route::get('detail_seminar/{id}','ProfileController@detail');

Route::get('sertifikat/{no_srtf}','SeminarController@scanSertifikat');
Route::get('approved/{id_personal}/{id_seminar}','SeminarController@scanTTD');
Route::get('iso/validity/{id}', 'Iso\IsoController@validity');


Route::get('sertifikat/cari','SertController@cari')->name('cari');
Route::get('sertifikat/{no_sert}/{email}','SertController@by_sert');
Route::get('sertifikat_v1/{no_sert}/{email}','SertController@sert_v1');
Route::get('sertifikat_v2/{no_sert}/{email}','SertController@sert_v2');
Route::get('sertifikat_v3/{no_sert}/{email}','SertController@sert_v3');
Route::get('approved/adji','SertController@ttd1');
Route::get('approved/iman','SertController@ttd2');
Route::get('approved/budi_susetyo','SertController@ttd3');
Route::get('approved/adji_n','SertController@ttd4');
Route::get('approved/viby','SertController@ttd_viby');
Route::get('approved/irwin','SertController@ttd_irwin');
Route::get('approved/irwin18','SertController@ttd_irwin18');
Route::get('approved/ludy18','SertController@ttd_ludy18');
Route::get('p3sm','SertController@p3sm');

Route::namespace('Laporan')->group(function(){
	Route::post('laporan/chain','LaporanController@chained_prov')->name('chained_prov');
	Route::post('laporan/hapus_obs','LaporanController@hapusObs')->name('hapusObs');
	Route::resource('laporan','LaporanController');
	Route::get('laporan/chained_scope/{id}','LaporanController@chained_scope');
	Route::get('laporan/print/{id}','LaporanController@print');
});

Route::namespace('Iso')->group(function(){
	Route::get('iso/print/{id}', 'IsoController@print');
	Route::get('iso/print_blanko/{id}', 'IsoController@print_blanko');

	Route::post('iso/bentuk_no', 'IsoController@bentukNo')->name('bentukNoIso');
});



Route::group(['middleware' => 'auth'], function () {

// Seminar

Route::group(['middleware' => 'auth.admin','prefix' => 'seminar'], function () {
	Route::get('/', 'SeminarController@index');
	Route::get('create','SeminarController@create');
	Route::post('store','SeminarController@store');
	Route::get('/{id}/edit', 'SeminarController@edit');
	Route::patch('/{id}/update', 'SeminarController@update');
	Route::patch('/{id}/update-draft', 'SeminarController@updateDraft');
	Route::delete('destroy', 'SeminarController@destroy');
	Route::get('detail/{id}','SeminarController@detail');
	Route::get('/{id}/publish', 'SeminarController@publish');
	Route::get('create/getKota/{id}','SeminarController@getKota');
	Route::get('cetak_sertifikat/{no_srtf}','SeminarController@cetakSertifikat');
	Route::get('kirim_email/{id}','SeminarController@kirimEmail');
	Route::get('send_email/{no_srtf}','SeminarController@sendEmail');
	Route::get('approve/{id}','SeminarController@approve');

});
// Route::get('cetak_sertifikat/{no_srtf}','SeminarController@cetakSertifikat');
// 	Route::get('kirim_email','SeminarController@kirimEmail');
// 	Route::get('send_email/{id}','SeminarController@sendEmail');

// End Seminar

Route::namespace('Iso')->group(function(){
	Route::post('iso/destroy', 'IsoController@destroy');
	Route::resource('isos', 'IsoController');
});

// TUK
Route::group(['middleware' => 'auth.admin','prefix' => 'tuk'], function () {
	Route::get('/','TUKController@index');
	Route::get('/create','TUKController@create');
	Route::post('/store','TUKController@store');
	Route::patch('/update','TUKController@update');
	Route::get('/create/getKota/{id}','TUKController@getKota');
	Route::get('/{id}/edit','TUKController@edit');
    Route::get('/{id}','TUKController@show');
	Route::delete('/destroy', 'TUKController@destroy');
});
// END TUK

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
	Route::get('/lengkapi/{id}/{id_personal}','InstansiController@lengkapi');
	Route::get('/create','InstansiController@create');
	Route::post('/store','InstansiController@store');
	Route::get('/lengkapi/{id}/{id_personal}','InstansiController@lengkapi');
	Route::patch('/store-lengkapi','InstansiController@storeLengkapi');
	Route::patch('/update','InstansiController@update');
	Route::get('/create/getKota/{id}','InstansiController@getKota');
	Route::get('/{id}/edit','InstansiController@edit');
    Route::get('/{id}','InstansiController@show');
	Route::delete('/destroy','InstansiController@destroy');
});
// End Instansi



	Route::group(['middleware' => 'auth.input'], function () {
		Route::get('/dashboard', 'HomeController@index');
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

Route::group(['middleware' => 'auth.admin','prefix' => 'import'], function () {
    Route::get('/','ImportController@index');
	Route::post('/','ImportController@import');
});



// Report
Route::group(['prefix' => 'report'], function () {

});
// end of Report


Route::group(['middleware' => 'auth'], function () {
    // Pembayaran

    // For User

    // End For User

    // For Midtrans

    // End For Midtrans

    // End Pembayaran
});
