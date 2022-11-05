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

Route::prefix('jib')->group(function () {
    Route::get('/', 'JibController@index');
});

Route::prefix('admin/jib')->as('jib-')->namespace('\Modules\Jib\Http\Controllers\Admin')->middleware(['auth'])->group(function () { // phpcs:ignore

    // WORKSPACE
    Route::get('workspace/{id}/restore', 'WorkspaceController@restore')->name('workspace.restore');
    Route::get('workspace/{id}/editworkspace', 'WorkspaceController@editworkspace')->name('workspace.editworkspace');
    Route::match(['get', 'post'], 'workspace/storeworkspace', 'WorkspaceController@storeworkspace')->name('workspace.storeworkspace');
    Route::resource('workspace', 'WorkspaceController');

    // WORKSPACE FORM PERSETUJUAN
    Route::get('workspace/createform/{id}', 'WorkspaceController@createform')->name('workspace.createform');
    Route::get('workspace/{id}/editform', 'WorkspaceController@editform')->name('workspace.editform');
    Route::match(['get', 'post'], 'workspace/storeform', 'WorkspaceController@storeform')->name('workspace.storeform');
    Route::match(['put', 'patch'], 'workspace/updateform/{id}', 'WorkspaceController@updateform')->name('workspace.updateform');
    Route::get('workspace/persetujuan/{id}/download', 'WorkspaceController@download')->name('workspace.download');
    Route::get('workspace/{id}/{uid}/download', 'WorkspaceController@download_fullsign')->name('workspace.download_fullsign');
    Route::get('workspace/mom/{id}/print', 'WorkspaceController@download_mom_print')->name('workspace.download_mom_print');
    Route::get('workspace/mom/{id}/{uid}/download', 'WorkspaceController@download_mom')->name('workspace.download_mom');

    // WORKSPACE FORM MOM
    Route::get('workspace/createmom/{id}', 'WorkspaceController@createmom')->name('workspace.createmom');
    Route::get('workspace/{id}/editmom', 'WorkspaceController@editmom')->name('workspace.editmom');
    Route::match(['get', 'post'], 'workspace/storemom', 'WorkspaceController@storemom')->name('workspace.storemom');
    Route::match(['put', 'patch'], 'workspace/updatemom/{id}', 'WorkspaceController@updatemom')->name('workspace.updatemom');

    // PENGAJUAN
    Route::get('pengajuan/trashed', 'PengajuanController@trashed')->name('pengajuan.trashed');
    Route::get('pengajuan/{id}/restore', 'PengajuanController@restore')->name('pengajuan.restore');
    Route::get('pengajuan/{uid}/download', 'PengajuanController@download')->name('pengajuan.download');
    Route::resource('pengajuan', 'PengajuanController');

//    Route::resource('selesai', 'SelesaiController');
});
