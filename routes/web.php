<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PotensiController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UmkmApplicantController as AdminUmkmApplicantController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UmkmApplicantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman publik
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('umkm/daftar', [UmkmApplicantController::class, 'store'])->name('umkm.apply');

/*
|--------------------------------------------------------------------------
| Admin: login (tanpa auth)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin: panel (wajib login)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('potensi', PotensiController::class)->except(['show']);
    Route::resource('berita', BeritaController::class)->except(['show']);
    Route::patch('umkm-pendaftar/{applicant}/status', [AdminUmkmApplicantController::class, 'updateStatus'])->name('umkm-applicants.status');

    Route::get('pengaturan', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('pengaturan', [SettingController::class, 'update'])->name('settings.update');
    Route::delete('pengaturan/hero-video', [SettingController::class, 'destroyHeroVideo'])->name('settings.hero-video.destroy');
});
