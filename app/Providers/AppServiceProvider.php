<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\UmkmApplicant;
use App\Models\Complaint;
use App\Models\Order;
use App\Models\Letter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('setting', Setting::current());

        View::composer('layouts.admin', function ($view): void {
            $view->with([
                'pendingApplicants' => UmkmApplicant::where('status', 'Menunggu Persetujuan')->count(),
                'newComplaints' => Complaint::where('status', 'Baru')->count(),
                'pendingOrders' => Order::whereIn('status', ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Diproses'])->count(),
                'newLetters' => Letter::where('status', Letter::STATUS_BARU)->count(),
            ]);
        });
    }
}
