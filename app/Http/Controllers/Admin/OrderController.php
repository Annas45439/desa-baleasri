<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('produk')->latest();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(12)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate(['status' => ['required', 'in:Menunggu Konfirmasi,Dikonfirmasi,Diproses,Dikirim,Selesai,Dibatalkan']]);
        $order->update($data);
        log_activity('UPDATE_PESANAN', "Mengubah status pesanan #{$order->kode} milik {$order->nama_pemesan} menjadi '{$order->status}'.");

        return back()->with('status', 'Status pesanan '.$order->kode.' berhasil diperbarui.');
    }
}
