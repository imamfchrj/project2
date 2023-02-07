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

    Route::get('anggaran/list-table', 'AnggaranController@list_anggaran')->name('master.list-table');

    Route::get('budget/download', 'BudgetController@download')->name('budget.download');
    // Route::get('budget/upload', 'BudgetController@upload')->name('budget.import');
    Route::post('budget/upload', 'BudgetController@budget_import')->name('budget.import');
    Route::resource('budget', 'BudgetController');
    
});