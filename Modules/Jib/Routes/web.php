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

Route::prefix('jib')->group(function() {
    Route::get('/', 'JibController@index');
});

Route::prefix('admin/jib')->as('jib-')->namespace('\Modules\Jib\Http\Controllers\Admin')->middleware(['auth'])->group(function () { // phpcs:ignore

//    Route::get('workspace/trashed', 'WorkspaceController@trashed')->name('workspace.trashed');
    Route::get('workspace/{id}/restore', 'WorkspaceController@restore')->name('workspace.restore');
    Route::get('workspace/{id}/editworkspace', 'WorkspaceController@editworkspace')->name('workspace.editworkspace');
    Route::get('workspace/createform/{id}', 'WorkspaceController@createform')->name('workspace.createform');
    Route::resource('workspace', 'WorkspaceController');

    Route::get('pengajuan/trashed', 'PengajuanController@trashed')->name('pengajuan.trashed');
    Route::get('pengajuan/{id}/restore', 'PengajuanController@restore')->name('pengajuan.restore');
    Route::resource('pengajuan', 'PengajuanController');

    Route::resource('selesai', 'SelesaiController');
});