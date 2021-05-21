<?php

use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\NewUserController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\DueController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\RecapLetter;
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
    return redirect(route('login'));
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
        Route::resource('iuran', DueController::class);
        Route::resource('klaim', ClaimController::class);
        Route::resource('saldo', BalanceController::class);
        Route::resource('pemadanan', MatchController::class);
        Route::resource('rekap', RecapLetter::class);
    });

    Route::middleware(['user_verified', 'role_or_permission:user'])->group(function () {
        Route::get('/home', [UserHomeController::class, 'home'])->name('user.home');
        Route::get('/pembayaran-iuran', [DueController::class, 'card'])->name('user.due.card');
        Route::get('/pengajuan-klaim', [ClaimController::class, 'form'])->name('user.claim.form');
        Route::get('/cek-saldo', [BalanceController::class, 'check'])->name('user.balance.check');
        Route::get('/update-profile', [UserHomeController::class, 'index'])->name('user.profile.index');
        Route::get('/update-password', [UserHomeController::class, 'password'])->name('user.profile.password');
    });
});
