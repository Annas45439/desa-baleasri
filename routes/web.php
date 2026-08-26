<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PotensiController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UmkmApplicantController as AdminUmkmApplicantController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\ApbdesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UmkmApplicantController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\OrderController;
use App\Services\RajaOngkirService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman publik
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('umkm/daftar', [UmkmApplicantController::class, 'store'])->name('umkm.apply');
Route::post('pengaduan', [ComplaintController::class, 'store'])->name('complaints.store');
Route::get('umkm', [UmkmController::class, 'index'])->name('umkm.index');
Route::get('umkm/{kategori}', [UmkmController::class, 'show'])->name('umkm.show');
Route::get('pesan/{potensi}', [OrderController::class, 'create'])->name('orders.create');
Route::post('pesan/{potensi}', [OrderController::class, 'store'])->name('orders.store');
Route::post('cek-ongkir', function (Illuminate\Http\Request $request, RajaOngkirService $rajaOngkir) {
    $data = $request->validate(['destination' => ['required', 'string', 'max:10'], 'weight' => ['required', 'integer', 'min:1', 'max:30000'], 'courier' => ['required', 'in:jne,pos,tiki,sicepat,jnt,anteraja']]);
    try {
        return response()->json(['data' => $rajaOngkir->calculate($data['destination'], $data['weight'], $data['courier'])]);
    } catch (Throwable $exception) {
        return response()->json(['message' => $exception->getMessage()], 422);
    }
})->name('shipping.rates');

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
    Route::get('pengaduan', [AdminComplaintController::class, 'index'])->name('complaints.index');
    Route::patch('pengaduan/{complaint}/status', [AdminComplaintController::class, 'updateStatus'])->name('complaints.status');
    Route::get('apbdes', [ApbdesController::class, 'index'])->name('apbdes.index');
    Route::post('apbdes', [ApbdesController::class, 'store'])->name('apbdes.store');
    Route::put('apbdes/{apbdes}', [ApbdesController::class, 'update'])->name('apbdes.update');
    Route::delete('apbdes/{apbdes}', [ApbdesController::class, 'destroy'])->name('apbdes.destroy');
    Route::resource('users', UserController::class)->only(['index', 'store', 'destroy']);
    Route::get('pesanan', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('pesanan/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

    Route::get('pengaturan', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('pengaturan', [SettingController::class, 'update'])->name('settings.update');
    Route::delete('pengaturan/hero-video', [SettingController::class, 'destroyHeroVideo'])->name('settings.hero-video.destroy');
});
