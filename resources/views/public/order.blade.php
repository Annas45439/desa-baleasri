@extends('layouts.app')

@section('title', 'Pesan '.$produk->nama)

@section('content')
<section class="order-section">
  <div class="container order-layout">
    <div class="order-product">
      <a href="{{ url()->previous() }}" class="back-link">&larr; Kembali ke katalog</a>
      <div class="order-product-image"><img src="{{ $produk->foto ? asset('storage/'.$produk->foto) : 'https://picsum.photos/seed/'.$produk->slug.'/700/520' }}" alt="{{ $produk->nama }}"></div>
      <span class="umkm-cat">{{ $produk->tag ?: 'UMKM' }}</span>
      <h1>{{ $produk->nama }}</h1>
      <p>{{ $produk->deskripsi ?: 'Produk unggulan warga Desa Baleasri.' }}</p>
    </div>
    <div class="order-form-card">
      <span class="kicker">Form Pemesanan</span>
      <h2>Pesan produk ini</h2>
      <p class="order-intro">Isi data singkat di bawah. Setelah dikirim, Anda akan diarahkan ke WhatsApp penjual.</p>
      <form method="POST" action="{{ route('orders.store', $produk) }}" class="order-form">
        @csrf
        <label>Nama Pemesan<input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap" required></label>
        <label>Nomor WhatsApp<input type="tel" name="kontak" value="{{ old('kontak') }}" placeholder="08xxxxxxxxxx" required></label>
        <label>Jumlah<input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" max="999" required></label>
        <label>Varian / Ukuran / Warna<input type="text" name="varian" value="{{ old('varian') }}" placeholder="Opsional, sesuai produk"></label>
        <label>Metode Pemenuhan<select name="metode" required><option value="">Pilih metode</option><option {{ old('metode') === 'Ambil di lokasi' ? 'selected' : '' }}>Ambil di lokasi</option><option {{ old('metode') === 'Kirim ke alamat' ? 'selected' : '' }}>Kirim ke alamat</option></select></label>
        <label class="full">Alamat Pengiriman<input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Alamat lengkap atau lokasi pengambilan" required></label>
        <label>Kode Pos Tujuan<input type="text" name="kode_pos" id="kodePos" inputmode="numeric" maxlength="5" placeholder="Contoh: 63318"></label>
        <label>Berat Paket (gram)<input type="number" name="berat" id="beratPaket" value="1000" min="1" max="30000" required></label>
        <div class="shipping-check full">
          <span id="shippingMessage">Biaya pengiriman dan kurir akan dibahas secara manual melalui WhatsApp setelah pesanan dikonfirmasi.</span>
        </div>
        <input type="hidden" name="ongkir" id="ongkirValue" value="0">
        <input type="hidden" name="layanan_kurir" id="layananKurirValue" value="Manual via WhatsApp">
        <label class="full">Catatan Khusus<textarea name="catatan" placeholder="Contoh: tanpa pedas, bungkus kado, atau permintaan lainnya">{{ old('catatan') }}</textarea></label>
        <button type="submit" class="order-submit"><svg class="icon"><use href="#ic-wa"/></svg> Lanjut ke WhatsApp</button>
      </form>
      @if($errors->any())<div class="order-errors">{{ $errors->first() }}</div>@endif
    </div>
  </div>
</section>
<script>
  const message = document.getElementById('shippingMessage');
  const kodePos = document.getElementById('kodePos');
  if (kodePos) {
    kodePos.addEventListener('input', () => {
      if (kodePos.value.trim()) {
        message.textContent = 'Biaya pengiriman dan kurir akan dibahas manual melalui WhatsApp setelah pesanan dikonfirmasi.';
      }
    });
  }
</script>
@endsection
