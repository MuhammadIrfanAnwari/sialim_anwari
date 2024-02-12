<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\Sub_kriteriaController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::get('/auth/login', [LoginController::class, 'login'])->name('login');
Route::post('/auth/post_login', [LoginController::class, 'post_login'])->name('post_login');
Route::get('/auth/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware'=>['auth', "cek_login:super_admin,user"]], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('sub_kriteria', Sub_kriteriaController::class);
    Route::resource('bagian', BagianController::class);
    Route::resource('dokumen', DokumenController::class);
    Route::resource('akun', UserController::class);

    Route::get('/buka_file/{id}', [DokumenController::class, 'buka_file'])->name('buka_file');
    Route::post('/validasi', [DokumenController::class, 'validasi'])->name('validasi');

    Route::post('/profile/edit', [ProfileController::class, 'edit'])->name('edit_profile');
});

Route::middleware('visitor')->group(function() {
    Route::group(['middleware'=>['auth', "cek_login:super_admin,user"]], function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('kriteria', KriteriaController::class);
        Route::resource('sub_kriteria', Sub_kriteriaController::class);
        Route::resource('bagian', BagianController::class);
        Route::resource('dokumen', DokumenController::class);
        Route::resource('akun', UserController::class);
    
        Route::get('/buka_file/{id}', [DokumenController::class, 'buka_file'])->name('buka_file');
        Route::post('/validasi', [DokumenController::class, 'validasi'])->name('validasi');
    
        Route::post('/profile/edit', [ProfileController::class, 'edit'])->name('edit_profile');
    });
});
