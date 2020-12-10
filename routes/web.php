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
// Route::get('test', 'RegistController@test');
Route::get('/notif/{magic}','UserController@notif');
Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('', 'FrontendController@index')->name('homeUI');
Route::get('reset', 'FrontendController@reset');
Route::get('statseminarfunc/{id}', 'StatistikSeminarController@filter');
Route::get('tesWA', 'FrontendController@kirimWA');
Route::get('tesWA2', 'FrontendController@kirimWA2');
Route::get('tesWA3', 'FrontendController@kirimWA3');

Route::get('blast/{id}', 'BlastingController@click');
Route::get('statistik','StatistikSeminarController@treeview');
Route::get('statistik/{id}','StatistikSeminarController@detail');

Route::post('reset/update', 'FrontendController@update');
Route::post('/autocomplete/fetch', 'FrontendController@fetch')->name('autocomplete.fetch');
Route::get('berita', 'FrontendController@berita');
Route::get('galeri', 'FrontendController@galeri');

Route::get('infoseminar','InfoSeminarController@index')->name('infoseminar');
Route::get('infoseminar/detail/{id}','InfoSeminarController@detail');
Route::get('infoseminar/daftar/{id}','InfoSeminarController@daftar');
Route::post('infoseminar/store/{id}','InfoSeminarController@store');
Route::get('kirimwa','SeminarController@kirimWA');

Route::get('registrasi','RegistController@index');
Route::post('registrasi/store','RegistController@store');
Route::get('registrasi/daftar/{slug}','RegistController@daftar');
Route::post('registrasi/save/{id}','RegistController@save');
Route::get('wa_regist', 'FrontendController@wa_regist');

Route::get('profile', 'ProfileController@edit')->name('profile.edit');
Route::post('profile', 'ProfileController@update')->name('profile.update');
Route::get('changepassword', 'ProfileController@changePassword')->name('profile.change');
Route::post('savepassword', 'ProfileController@savePassword')->name('changepassword');
Route::get('detail_seminar/{id}','ProfileController@detail');

Route::get('sertifikat/{no_srtf}','SeminarController@scanSertifikat');
Route::get('approved/{id_personal}/{id_seminar}','SeminarController@scanTTD');
Route::get('iso/validity/{id}', 'Iso\IsoController@validity');

Route::post('chainnegara/{id}','PersonalController@chainednegara');
Route::post('personals/chain','PersonalController@chained_prov');
Route::post('chain/filterprovpersonil','PersonalController@filterprovpersonil');
Route::post('detail_personil_modal','PersonalController@detail');


// Chained

Route::post('select_jns_usaha_skp_ak3','ChainedController@selectjnsusahaskpak3');
Route::post('chain/filterprovdokperson','ChainedController@filterprovdokperson');
Route::post('select_bidang_skp_ak3','ChainedController@selectbidangdokkpak3');

Route::get('chain/searchPersonilByName','ChainedController@searchPersonilByName')->name('searchPersonilByName');
Route::get('chain/searchInstansiByName','ChainedController@searchInstansiByName')->name('searchInstansiByName');


Route::post('select_temp_bidang_skp_ak3','ChainedController@selectbidangskpak3');
Route::post('select_temp_namasrtf_skp_ak3','ChainedController@selectnamasrtfskpak3');
Route::post('select_temp_jnsdok_skp_ak3','ChainedController@selectjnsdokskpak3');
Route::post('add_temp_skp_ak3','ChainedController@addskpak3');
Route::post('delete_temp_skp_ak3','ChainedController@deleteskpak3');
Route::post('delete_all_temp_skp_ak3','ChainedController@deleteallskpak3');

Route::post('select_temp_namadok_skp_ak3','ChainedController@selectnamadokskpak3');
Route::post('select_temp_bidangdok_skp_ak3','ChainedController@selectbidangdokskpak3');

// End Chained


Route::post('chain/filterprovbu','InstansiController@filterprovbu');
Route::post('register_perusahaan/chain','CompRegister@chained_prov');

Route::group(['prefix' => 'presensi'], function () {
	Route::get('/{id}','AbsensiController@index')->name('presensi');
	Route::get('datang/{id}','AbsensiController@datang');
	Route::post('pulang/{id}','AbsensiController@pulang');
	Route::get('penilaian/{id}','AbsensiController@penilaian');
	// Route::get('pulang/{id}','AbsensiController@pulang');
});


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

    Route::get('pembayaran', 'PembayaranController@index' );

    Route::get('kegiatan', 'KegiatanController@index')->name('kegiatan.index');
    Route::get('kegiatan/detail/{id}','KegiatanController@detail');

    Route::group(['middleware' => 'auth.admin','prefix' => 'timmarketing'], function () {

		// Tim Marketing

		Route::get('/create', 'TimMarketingController@create');
		Route::post('/save','TimMarketingController@store');
		Route::get('/{id}/edit','TimMarketingController@edit');
		Route::post('/update','TimMarketingController@update');
		Route::post('/destroy','TimMarketingController@destroy');
		Route::post('/filter', 'TimMarketingController@filter');
		Route::get('/{id}', 'TimMarketingController@index');

		// Route::post('timproduksi/changepjk3','ChainedController@changepjk3');
		Route::post('/changelevelatas','TimMarketingController@changelevelatas');
		Route::post('/changetimprod','TimMarketingController@changetimprod');
		Route::post('/changebadanusaha','TimMarketingController@changebadanusaha');
		Route::post('/autofillnpwp','TimMarketingController@autofillnpwp');
		Route::post('/autofilltimprod','TimMarketingController@autofilltimprod');
        // end

    });

    Route::group(['middleware' => 'auth.admin','prefix' => 'timproduksi'], function () {
        // Tim Produksi
        Route::get('/create', 'TimProduksiController@create');
        Route::post('/save','TimProduksiController@store');
        Route::get('/{id}/edit','TimProduksiController@edit');
        Route::post('/update','TimProduksiController@update');
        Route::post('/destroy','TimProduksiController@destroy');
        Route::post('/filter', 'TimProduksiController@filter');
        Route::post('/changepjk3','ChainedController@changepjk3');
        Route::post('/changelevelatas','ChainedController@changelevelatas');
        Route::post('/autofillnpwp','TimProduksiController@autofillnpwp');
        Route::get('/{id}', 'TimProduksiController@index');
        // end
    });

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
	Route::post('/meeting/{id}','SeminarController@meeting');
	Route::get('create/getKota/{id}','SeminarController@getKota');
	Route::get('cetak_sertifikat/{no_srtf}','SeminarController@cetakSertifikat');
	Route::get('kirim_email/{id}','SeminarController@kirimEmail');
	Route::get('send_email/{no_srtf}','SeminarController@sendEmail');
	Route::get('approve/{id}','SeminarController@approve');
	Route::post('kirimlink/{id}','SeminarController@kirimLink');
    Route::post('kirimlink2/{id}','SeminarController@kirimLink2');
    Route::post('upload-materi/{id}','SeminarController@uploadMateri');
	Route::get('mulai/{id}','SeminarController@mulai');
	Route::get('selesai/{id}','SeminarController@selesai');
	Route::get('feedback/{id}','SeminarController@feedback');
	Route::get('download-feedback/{id}','SeminarController@downloadFeedback');
	Route::get('download-kehadiran/{id}','SeminarController@downloadKehadiran');
    Route::get('statistik/{id}','StatistikSeminarController@index');
    Route::post('blast/{id}', 'SeminarController@blast');

});

Route::get('ijinppkb/filter', 'IjinPPKBController@index');
Route::resource('ijinppkb', 'IjinPPKBController');
Route::get('chain/searchPersonilByName','IjinPPKBController@searchPersonilByName')->name('searchPersonilByName');
Route::post('ijinppkb/get_pjk3/{id}','IjinPPKBController@getPjk3');
Route::post('ijinppkb/filter', 'IjinPPKBController@filter');
Route::post('data_skp_pjk3_modal','IjinPPKBController@dataPjk3Modal');
Route::post('data_ahli_pjk3_modal','IjinPPKBController@dataAhli3Modal');

Route::post('select_temp_skp_pjk3','IjinPPKBController@selectskppjk3');
Route::post('add_temp_skp_pjk3','IjinPPKBController@addskppjk3');
Route::post('delete_temp_skp_pjk3','IjinPPKBController@deleteskppjk3');
Route::post('delete_all_temp_skp_pjk3','IjinPPKBController@deleteallskppjk3');


Route::group(['middleware' => 'auth.admin','prefix' => 'dokpersonal'], function () {
	Route::get('/', 'DokPersonalController@index');
	Route::get('/create', 'DokPersonalController@create');
	Route::get('/{id}/edit', 'DokPersonalController@edit');
	Route::post('/store', 'DokPersonalController@store');
    Route::patch('/update/{id}', 'DokPersonalController@update');
	Route::post('/get_personal/{idpjk3}/{id}','DokPersonalController@getPersonal');
	Route::post('/filter', 'DokPersonalController@filter');
	Route::get('/filter', 'DokPersonalController@index');
	Route::get('/detail','DokPersonalController@show');
	Route::post('/get_skpak3/{id}','DokPersonalController@getSkpAk3');
});
// Route::get('cetak_sertifikat/{no_srtf}','SeminarController@cetakSertifikat');
// 	Route::get('kirim_email','SeminarController@kirimEmail');
// 	Route::get('send_email/{id}','SeminarController@sendEmail');

// End Seminar

//

// Kantor

Route::group(['middleware' => 'auth.admin','prefix' => 'kantor'], function () {
	Route::get('/', 'KantorController@index');
	Route::get('create', 'KantorController@create');
	Route::post('store', 'KantorController@store');
	Route::get('{id}/edit', 'KantorController@edit');
	Route::patch('update/{id}', 'KantorController@update');
	Route::post('changelevelatas', 'KantorController@changelevelatas');
	Route::post('filter', 'KantorController@filter');
	Route::delete('/destroy','KantorController@destroy');
	// Route::get('detail/{id}', 'KantorController@detail');
});
// End Kantor


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
	Route::get('/filter', 'PersonalController@index');
	Route::post('/store','PersonalController@store');
	Route::patch('/update','PersonalController@update');
	Route::get('/create/getKota/{id}','PersonalController@getKota');
	Route::get('/{id}/edit','PersonalController@edit');
    Route::get('/{id}','PersonalController@show');
	Route::delete('/destroy', 'PersonalController@destroy');
	Route::post('/filter', 'PersonalController@filter');
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
	Route::get('/filter', 'InstansiController@index');
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
	Route::post('/changelevelatas','InstansiController@changelevelatas');
	Route::post('/filter', 'InstansiController@filter');
});
// End Instansi



	Route::group(['middleware' => 'auth.input'], function () {
		Route::get('/dashboard', 'HomeController@index');
	});

	Route::group(['middleware' => 'auth.admin'], function () {
		Route::resources([
			'users' => 'UserController',
        ]);
		Route::get('/force-logout', 'UserController@forceLogout');

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
