<?php

namespace App\Http\Controllers;

use App\Models\Potensi;
use App\Models\Setting;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Potensi $potensi)
    {
        abort_unless($potensi->kategori === 'umkm' && $potensi->tampil, 404);

        return view('public.order', [
            'produk' => $potensi,
            'setting' => Setting::current(),
        ]);
    }

    public function store(Request $request, Potensi $potensi)
    {
        abort_unless($potensi->kategori === 'umkm' && $potensi->tampil, 404);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'kontak' => ['required', 'string', 'max:40'],
            'jumlah' => ['required', 'integer', 'min:1', 'max:999'],
            'varian' => ['nullable', 'string', 'max:150'],
            'metode' => ['required', 'in:Ambil di lokasi,Kirim ke alamat'],
            'ongkir' => ['nullable', 'integer', 'min:0'],
            'layanan_kurir' => ['nullable', 'string', 'max:40'],
            'kode_pos' => ['nullable', 'string', 'max:10'],
            'alamat' => ['required', 'string', 'max:500'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $setting = Setting::current();
        $nomor = preg_replace('/[^0-9]/', '', (string) ($potensi->kontak_whatsapp ?: $setting->whatsapp_admin));
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        abort_if(!$nomor, 422, 'Nomor WhatsApp penjual belum tersedia.');

        $order = Order::create($data + [
            'kode' => 'BL-' . now()->format('ymdHis') . random_int(10, 99),
            'potensi_id' => $potensi->id,
            'status' => 'Menunggu Konfirmasi',
        ]);

        $pesan = "Halo, saya ingin memesan produk dari {$setting->nama_desa}.\n\n"
            . "*NOMOR PESANAN: {$order->kode}*\n"
            . "*DETAIL PESANAN*\n"
            . "Produk: {$potensi->nama}\n"
            . "Kategori: " . ($potensi->tag ?: 'UMKM') . "\n"
            . "Jumlah: {$data['jumlah']}\n\n"
            . "Varian / ukuran / warna: " . ($data['varian'] ?: '-') . "\n"
            . "Metode: {$data['metode']}\n\n"
            . "Kurir: " . ($data['layanan_kurir'] ?: '-') . "\n"
            . "Ongkir: " . (!empty($data['ongkir']) ? 'Rp ' . number_format($data['ongkir'], 0, ',', '.') : '-') . "\n"
            . "*DATA PEMESAN*\n"
            . "Nama: {$data['nama']}\n"
            . "Kontak: {$data['kontak']}\n"
            . "Kode pos: " . ($data['kode_pos'] ?: '-') . "\n"
            . "Alamat: {$data['alamat']}\n"
            . "Catatan: " . ($data['catatan'] ?: '-') . "\n\n"
            . "Mohon informasi ketersediaan dan total harganya. Terima kasih.";

        return redirect()->away('https://wa.me/' . $nomor . '?text=' . urlencode($pesan));
    }
}
