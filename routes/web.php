<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\RoleController as AdminRole;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\SettingController as AdminSetting;
use App\Http\Controllers\Admin\NotificationController as AdminNotification;

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

Route::get('/', function () {
//    return view('welcome');
    return view('auth.login');
});

Route::get('/home', function () {
    return view('home');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard.index');

    Route::get('roles/reload-permissions/{id}', [AdminRole::class, 'reloadPermissions'])->name('roles.update');
    Route::get('roles/reload-permissions', [AdminRole::class, 'reloadPermissions'])->name('roles.update');
    Route::resource('roles', AdminRole::class);
    Route::resource('users', AdminUser::class);

    Route::get('settings/remove/{id}', [AdminSetting::class, 'remove'])->name('settings.update');
    Route::get('settings', [AdminSetting::class, 'index'])->name('settings.update');
    Route::post('settings', [AdminSetting::class, 'update'])->name('settings.update');

    Route::get('users_login_his', [AdminUser::class, 'users_login_his'])->name('users.users_login_his');

    Route::get('profile/{id}/editprofile', [AdminUser::class, 'profile'])->name('users.profile');
    Route::match(['put', 'patch'], 'profile/{id}', [AdminUser::class, 'profile_update'])->name('users.profile_update');

    Route::get('/notification', [AdminNotification::class, 'index'])->name('notification.index');
    Route::get('/notification/markasread', [AdminNotification::class, 'markasread'])->name('notification.read');
    Route::get('/notification/{id}/readbyid', [AdminNotification::class, 'readbyid'])->name('notification.readbyid');
});
