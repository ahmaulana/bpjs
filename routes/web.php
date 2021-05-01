<?php

use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\NewUserController;
use App\Http\Controllers\user\HomeController as UserHomeController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

Route::get('/redirect', function () {    

    if (User::findOrFail(auth()->user()->id)->hasRole(['Admin', 'admin'])) {
        return redirect()->route('admin.home');
    } else {
        return redirect()->route('user.home');
    }
})->name('redirect');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => 'auth'], function () {

    Route::middleware(['role_or_permission:admin'])->prefix('admin')->group(function () {

        Route::get('/home', [HomeController::class, 'index'])->name('admin.home');

        Route::resource('peserta-baru', NewUserController::class);
    });

    Route::middleware(['user_verified', 'role_or_permission:user'])->group(function () {
        Route::get('/home', [UserHomeController::class, 'index'])->name('user.home');
    });
});
