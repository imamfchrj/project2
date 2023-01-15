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

Route::prefix('master')->group(function () {
    Route::get('/', 'MasterController@index');
});

Route::prefix('admin/master')->as('master-')->namespace('\Modules\Master\Http\Controllers\Admin')->middleware(['auth'])->group(function () { // phpcs:ignore

    // CUSTOMER
    Route::resource('customer', 'CustomerController');
    Route::resource('anggaran', 'AnggaranController');
    Route::resource('jenis', 'JenisController');
    Route::resource('kategori', 'KategoriController');
    Route::resource('kesimpulan', 'KesimpulanController');
    Route::resource('risiko', 'RisikoController');
    Route::resource('segment', 'SegmentController');
    Route::resource('status', 'StatusController');
    Route::resource('pemeriksa', 'PemeriksaController');
});