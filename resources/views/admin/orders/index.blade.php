@extends('layouts.admin')

@section('title', 'Pesanan')
@section('page-title', 'Pesanan UMKM')
@section('page-subtitle', 'Pantau pesanan warga dan status pengirimannya.')

@section('content')
<div class="toolbar">
  <div class="filter-tabs">
    <a href="{{ route('admin.orders.index') }}" class="{{ request('status') ? '' : 'active' }}">Semua</a>
    @foreach(['Menunggu Konfirmasi', 'Dikonfirmasi', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'] as $status)
      <a href="{{ route('admin.orders.index', ['status' => $status]) }}" class="{{ request('status') === $status ? 'active' : '' }}">{{ $status }}</a>
    @endforeach
  </div>
</div>
<div class="data-table">
  <table>
    <thead><tr><th>Kode</th><th>Produk</th><th>Pemesan</th><th>Detail</th><th>Status</th><th>Ubah Status</th></tr></thead>
    <tbody>
      @forelse($orders as $order)
        <tr>
          <td><strong>{{ $order->kode }}</strong><br><small>{{ $order->created_at->format('d M Y H:i') }}</small></td>
          <td>{{ $order->produk->nama ?? 'Produk dihapus' }}</td>
          <td><strong>{{ $order->nama }}</strong><br><small>{{ $order->kontak }}</small></td>
          <td>{{ $order->jumlah }} pcs<br><small>{{ $order->metode }} · {{ $order->layanan_kurir ?: 'Tanpa kurir' }} · {{ Str::limit($order->alamat, 35) }}</small></td>
          <td><span class="status-pill {{ in_array($order->status, ['Selesai', 'Dikonfirmasi']) ? 'st-selesai' : ($order->status === 'Dibatalkan' ? 'st-baru' : 'st-proses') }}">{{ $order->status }}</span></td>
          <td><form method="POST" action="{{ route('admin.orders.status', $order) }}" class="status-form">@csrf @method('PATCH')<select name="status" onchange="this.form.submit()">@foreach(['Menunggu Konfirmasi', 'Dikonfirmasi', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'] as $status)<option {{ $order->status === $status ? 'selected' : '' }}>{{ $status }}</option>@endforeach</select></form></td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center; color:var(--text-muted); padding:30px 0;">Belum ada pesanan.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div style="margin-top:18px;">{{ $orders->links() }}</div>
@endsection
