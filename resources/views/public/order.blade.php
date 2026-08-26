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
        <label>Kurir<select name="kurir" id="kurir"><option value="jne">JNE</option><option value="pos">POS Indonesia</option><option value="tiki">TIKI</option><option value="sicepat">SiCepat</option><option value="jnt">J&amp;T</option><option value="anteraja">AnterAja</option></select></label>
        <div class="shipping-check full"><button type="button" id="checkShippingBtn">Cek Ongkir</button><span id="shippingMessage">Isi kode pos dan berat untuk melihat pilihan tarif.</span></div>
        <input type="hidden" name="ongkir" id="ongkirValue">
        <input type="hidden" name="layanan_kurir" id="layananKurirValue">
        <label class="full">Catatan Khusus<textarea name="catatan" placeholder="Contoh: tanpa pedas, bungkus kado, atau permintaan lainnya">{{ old('catatan') }}</textarea></label>
        <button type="submit" class="order-submit"><svg class="icon"><use href="#ic-wa"/></svg> Lanjut ke WhatsApp</button>
      </form>
      @if($errors->any())<div class="order-errors">{{ $errors->first() }}</div>@endif
    </div>
  </div>
</section>
<script>
  const shippingButton = document.getElementById('checkShippingBtn');
  shippingButton?.addEventListener('click', async () => {
    const message = document.getElementById('shippingMessage');
    const destination = document.getElementById('kodePos').value.trim();
    if (!destination) { message.textContent = 'Kode pos tujuan wajib diisi.'; return; }
    message.textContent = 'Mengambil tarif Komship...';
    try {
      const response = await fetch('{{ route('shipping.rates') }}', { method: 'POST', headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'}, body: JSON.stringify({destination, weight: document.getElementById('beratPaket').value, courier: document.getElementById('kurir').value}) });
      const result = await response.json();
      if (!response.ok) throw new Error(result.message || 'Tarif belum tersedia.');
      const first = result.data[0];
      if (!first) throw new Error('Layanan kurir tidak tersedia untuk tujuan ini.');
      document.getElementById('ongkirValue').value = first.value;
      document.getElementById('layananKurirValue').value = first.service;
      message.textContent = `${first.service} - Rp ${new Intl.NumberFormat('id-ID').format(first.value)} - estimasi ${first.etd} hari`;
    } catch (error) { message.textContent = error.message; }
  });
</script>
@endsection
