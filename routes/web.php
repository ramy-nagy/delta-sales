<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
    return view('welcome');
});

require __DIR__ . '/auth.php';
// lang middleware
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath',
        'auth'
    ]
], function () {

    Route::get('/users',     [DashboardController::class, 'users'])->name('users.index');
    Route::get('/roles',     [DashboardController::class, 'roles'])->name('roles.index');
    Route::get('/generate',  [DashboardController::class, 'generate'])->name('generate.index');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    // Route::resource('/roles', RoleController::class)->names('roles');

    
    // Route::resource('users', UserController::class)->names('users');

});
