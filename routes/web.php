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
use App\Http\Controllers\Admin\LetterController as AdminLetterController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\UmkmApplicantController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LetterController;
use App\Services\RajaOngkirService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman publik
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('profil-desa', [PublicPageController::class, 'profil'])->name('profil.desa');
Route::get('apbdes', [PublicPageController::class, 'apbdes'])->name('apbdes.public');
Route::get('wisata', [PublicPageController::class, 'wisata'])->name('wisata');
Route::get('berita', [PublicPageController::class, 'berita'])->name('berita.public');
Route::get('layanan', [PublicPageController::class, 'pengaduan'])->name('layanan');
Route::get('pengaduan', [PublicPageController::class, 'pengaduan'])->name('pengaduan.public');
Route::post('umkm/daftar', [UmkmApplicantController::class, 'store'])->name('umkm.apply');
Route::post('pengaduan', [ComplaintController::class, 'store'])->name('complaints.store');
Route::get('umkm', [UmkmController::class, 'index'])->name('umkm.index');
Route::get('umkm/{kategori}', [UmkmController::class, 'show'])->name('umkm.show');
Route::get('pesan/{potensi}', [OrderController::class, 'create'])->name('orders.create');
Route::post('pesan/{potensi}', [OrderController::class, 'store'])->name('orders.store');
Route::get('surat', [LetterController::class, 'index'])->name('letters.index');
Route::post('surat', [LetterController::class, 'store'])->name('letters.store');
Route::get('surat-tracking', [LetterController::class, 'tracking'])->name('letters.tracking');
Route::post('surat-search', [LetterController::class, 'search'])->name('letters.search');
Route::get('surat/{letter}', [LetterController::class, 'show'])->name('letters.show');
Route::get('surat/{letter}/download-pdf', [LetterController::class, 'downloadPdf'])->name('letters.download-pdf');
Route::get('surat/{letter}/download-dokumen', [LetterController::class, 'downloadDokumen'])->name('letters.download-dokumen');
Route::get('api/surat/status', [LetterController::class, 'getStatus'])->name('letters.api-status');
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
Route::get('auth/google', [\App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [\App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::prefix(env('ADMIN_PATH', 'kelola-desa-baleasri'))->name('admin.')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin']);
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.attempt');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin: panel (wajib login)
|--------------------------------------------------------------------------
*/
Route::prefix(env('ADMIN_PATH', 'kelola-desa-baleasri'))->name('admin.')->middleware(['admin.auth', 'admin.role:super_admin,admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('health', [DashboardController::class, 'health'])->name('health');

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
    Route::patch('users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password');
    Route::get('users/{user}/password/reauth', function (\App\Models\User $user, Illuminate\Http\Request $request) {
        $request->session()->put('password_reauth_user_id', $user->id);

        return redirect()->route('auth.google');
    })->name('users.password.reauth');
    Route::get('pesanan', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('pesanan/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    
    Route::get('surat', [AdminLetterController::class, 'index'])->name('letters.index');
    Route::get('surat/{letter}/edit', [AdminLetterController::class, 'edit'])->name('letters.edit');
    Route::put('surat/{letter}', [AdminLetterController::class, 'update'])->name('letters.update');
    Route::patch('surat/{letter}/status', [AdminLetterController::class, 'updateStatus'])->name('letters.update-status');
    Route::delete('surat/{letter}', [AdminLetterController::class, 'destroy'])->name('letters.destroy');
    Route::get('surat-report', [AdminLetterController::class, 'report'])->name('letters.report');
    Route::get('surat-report/export', [AdminLetterController::class, 'exportReport'])->name('letters.export-report');

    Route::get('pengaturan', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('pengaturan', [SettingController::class, 'update'])->name('settings.update');
});

Route::get('api/debug-db-users', function () {
    return response()->json([
        'db_connection' => config('database.default'),
        'total_users'   => \App\Models\User::count(),
        'users'         => \App\Models\User::all(['id', 'name', 'email', 'role', 'is_developer', 'created_at']),
        'mail_from'     => config('mail.from.address'),
    ]);
});

