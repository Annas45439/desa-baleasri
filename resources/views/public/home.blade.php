@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<div class="marquee-bar" aria-label="Informasi Desa Baleasri">
  <div class="marquee-track">
    @for($i = 0; $i < 2; $i++)
      <span><svg class="icon"><use href="#ic-sparkle"/></svg> {{ $setting->nama_desa ?? 'Desa Baleasri' }}</span>
      <span>Rumah yang asri, untuk warga</span>
      <span><svg class="icon"><use href="#ic-pin"/></svg> {{ $setting->alamat ?? 'Magetan, Jawa Timur' }}</span>
    @endfor
  </div>
</div>

<div class="hero">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
  <div class="container hero-inner">
    <div class="emblem">
      <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="50" cy="50" r="48" fill="var(--ink)"/>
        <path d="M12 58 Q30 44 50 58 T88 58" stroke="var(--teal)" stroke-width="4" fill="none" stroke-linecap="round"/>
        <path d="M12 68 Q30 56 50 68 T88 68" stroke="var(--gold)" stroke-width="3" fill="none" stroke-linecap="round" opacity="0.8"/>
        <path d="M50 20 C46 30 46 38 50 46 C54 38 54 30 50 20Z" fill="var(--gold)"/>
      </svg>
    </div>
    <div class="filosofi-pill"><span class="word">BALEASRI</span><span class="desc">Bale yang asri, desa yang berarti</span></div>
    <h1>{{ $setting->tagline ?? 'Rumah yang Asri, untuk Warga' }}</h1>
    <p>{{ $setting->deskripsi_hero ?? '' }}</p>
    <div class="hero-actions">
      <a href="#wisata" class="btn-shine">Jelajahi Desa &rarr;</a>
      <a href="#umkm" class="btn-outline">Lihat UMKM</a>
    </div>
  </div>
  <div class="container">
    <div class="hero-visual reveal">
      {{-- Video hero diprioritaskan; kalau kosong, fallback ke foto hero --}}
      @if($setting->hero_video)
        <video autoplay muted loop playsinline poster="{{ $setting->hero_image ? asset('storage/'.$setting->hero_image) : '' }}"
               style="width:100%; height:440px; object-fit:cover;">
          <source src="{{ asset('storage/'.$setting->hero_video) }}" type="video/mp4">
        </video>
      @elseif($setting->hero_image)
        <img src="{{ asset('storage/'.$setting->hero_image) }}" alt="{{ $setting->nama_desa }}">
      @else
        <img src="https://picsum.photos/seed/baleasrihero/1400/900" alt="{{ $setting->nama_desa }}">
      @endif
      <div class="tag"><svg class="icon"><use href="#ic-pin"/></svg> {{ $setting->nama_desa ?? 'Desa Baleasri' }}</div>
    </div>
  </div>
</div>

<section id="layanan">
  <div class="container">
    <div class="section-head reveal">
      <span class="kicker">Layanan Digital</span>
      <h2>Semua yang kamu butuh, satu tempat.</h2>
      <p>Dari profil desa sampai pesan produk UMKM lewat WhatsApp &mdash; tinggal klik.</p>
    </div>
    <div class="bento">
      <div class="bento-card b1 reveal"><svg class="icon" style="width:1.7rem;height:1.7rem;"><use href="#ic-wisata"/></svg><h3>Wisata Desa</h3><p>Destinasi & spot favorit.</p></div>
      <a href="#umkm" class="bento-card b2 reveal"><span class="new-badge">Unggulan</span><svg class="icon" style="width:1.7rem;height:1.7rem;"><use href="#ic-umkm"/></svg><h3>Pasar UMKM</h3><p>Pesan langsung via WhatsApp.</p></a>
      <div class="bento-card b3 reveal"><svg class="icon" style="width:1.7rem;height:1.7rem;"><use href="#ic-admin"/></svg><h3>Administrasi</h3><p>Info & unduh formulir.</p></div>
      <div class="bento-card b4 reveal"><svg class="icon" style="width:1.7rem;height:1.7rem;"><use href="#ic-apbdes"/></svg><h3>APBDes</h3><p>Transparansi anggaran.</p></div>
      <div class="bento-card b5 reveal"><svg class="icon" style="width:1.7rem;height:1.7rem;"><use href="#ic-aduan"/></svg><h3>Aspirasi & Aduan</h3><p>Sampaikan & pantau status.</p></div>
      <div class="bento-card b6 reveal"><svg class="icon" style="width:1.7rem;height:1.7rem;"><use href="#ic-bale"/></svg><h3>Profil & Sejarah</h3><p>Kenali cerita desa kami.</p></div>
    </div>

    <div class="stats-band reveal">
      <div class="stat"><div class="n" data-count="{{ $setting->stat_pendidikan }}">0</div><div class="l">Sarana Pendidikan</div></div>
      <div class="stat"><div class="n" data-count="{{ $setting->stat_umkm }}">0</div><div class="l">UMKM Unggulan</div></div>
      <div class="stat"><div class="n" data-count="{{ $setting->stat_wisata }}">0</div><div class="l">Destinasi Wisata</div></div>
      <div class="stat"><div class="n" data-count="{{ $setting->stat_embung }}">0</div><div class="l">Embung Ikonik</div></div>
    </div>
  </div>
</section>

@if($setting->sambutan)
<section style="background:#fff; padding-top:0;">
  <div class="container">
    <div class="section-head reveal">
      <span class="kicker">Sambutan</span>
      <h2>Sambutan {{ $setting->nama_kepala_desa ?? 'Kepala Desa' }}</h2>
    </div>
    <div style="display:flex; gap:28px; align-items:center; flex-wrap:wrap;" class="reveal">
      @if($setting->foto_kepala_desa)
        <img src="{{ asset('storage/'.$setting->foto_kepala_desa) }}" alt="{{ $setting->nama_kepala_desa }}"
             style="width:160px; height:160px; border-radius:24px; object-fit:cover; flex-shrink:0;">
      @endif
      <p style="max-width:640px; font-size:1.05rem; color:#3a473f;">{{ $setting->sambutan }}</p>
    </div>
  </div>
</section>
@endif

<section id="wisata" style="background:#fff;">
  <div class="container">
    <div class="section-head reveal">
      <span class="kicker">Destinasi</span>
      <h2>Spot favorit buat healing & konten.</h2>
    </div>
    <div class="wisata-grid">
      @forelse($wisata as $w)
        <div class="tilt-card reveal">
          <img src="{{ $w->foto ? asset('storage/'.$w->foto) : 'https://picsum.photos/seed/'.$w->slug.'/500/600' }}" alt="{{ $w->nama }}">
          <div class="tilt-info"><span class="tilt-tag">{{ $w->tag ?? 'Wisata' }}</span><h3>{{ $w->nama }}</h3></div>
        </div>
      @empty
        <p style="color:#4a564d;">Belum ada data wisata. Tambahkan lewat panel admin.</p>
      @endforelse
    </div>
    <div class="safety-box reveal">
      <div class="warn-icon"><svg class="icon" style="width:1.2rem;height:1.2rem;"><use href="#ic-warn"/></svg></div>
      <p><strong>Perhatian Keselamatan</strong> Selalu ikuti rambu dan imbauan petugas desa di setiap lokasi wisata.</p>
    </div>
  </div>
</section>

<section id="umkm">
  <div class="container">
    <div class="section-head reveal">
      <span class="kicker">Ekonomi Desa</span>
      <h2>Geser, pilih, pesan. Simpel.</h2>
    </div>
    <div class="umkm-scroll">
      @forelse($umkm as $u)
        <div class="umkm-card reveal">
          <div class="umkm-img"><img src="{{ $u->foto ? asset('storage/'.$u->foto) : 'https://picsum.photos/seed/'.$u->slug.'/400/300' }}" alt="{{ $u->nama }}"></div>
          <div class="umkm-body">
            <span class="umkm-cat">{{ $u->tag ?? 'UMKM' }}</span>
            <h3>{{ $u->nama }}</h3>
            @php
              $wa = $u->kontak_whatsapp ?: $setting->whatsapp_admin;
              $waText = 'Halo, saya tertarik dengan produk '.$u->nama.' dari '.($setting->nama_desa ?? 'Desa Baleasri');
            @endphp
            @if($wa)
              <a href="https://wa.me/{{ $wa }}?text={{ urlencode($waText) }}" target="_blank" class="wa-btn"><svg class="icon"><use href="#ic-wa"/></svg> Pesan</a>
            @endif
          </div>
        </div>
      @empty
        <p style="color:#4a564d;">Belum ada produk UMKM. Tambahkan lewat panel admin.</p>
      @endforelse
    </div>
    <div class="umkm-register reveal">
      <div class="umkm-register-grid">
        <div>
          <span class="kicker">Daftar UMKM</span>
          <h3 class="register-title">Ingin jualan di desa? Daftarkan usaha Anda.</h3>
          <p class="register-copy">Warga bisa mendaftarkan usaha secara cepat. Admin desa akan memeriksa dan menyetujui data yang masuk.</p>
          <button type="button" class="register-trigger" id="openUmkmModalBtn">Daftar Sekarang</button>
          @if(session('umkm_status'))<div class="submission-status">{{ session('umkm_status') }}</div>@endif
        </div>
        <div class="status-panel">
          <span class="kicker">Status Pendaftaran</span>
          <div class="reg-list">
            @forelse($umkmApplicants as $applicant)
              <div class="reg-card">
                <div class="reg-card-head"><div class="reg-name">{{ $applicant->nama_usaha }}</div><span class="status-badge {{ $applicant->status === 'Disetujui' ? 'approved' : ($applicant->status === 'Ditolak' ? 'rejected' : 'pending') }}">{{ $applicant->status }}</span></div>
                <p>{{ $applicant->deskripsi }}</p>
                <div class="reg-meta"><span>{{ $applicant->pemilik }}</span><span>{{ $applicant->kategori }}</span><span>{{ $applicant->lokasi }}</span></div>
              </div>
            @empty
              <div class="reg-card"><p>Belum ada pendaftaran UMKM.</p></div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
    <div class="umkm-modal" id="umkmFormModal" aria-hidden="true">
      <div class="umkm-modal-card">
        <button type="button" class="umkm-modal-close" id="closeUmkmModalBtn" aria-label="Tutup">&times;</button>
        <span class="kicker">Form Pendaftaran</span>
        <h3 class="modal-title">Pendaftaran UMKM Baru</h3>
        <form method="POST" action="{{ route('umkm.apply') }}" class="reg-form">
          @csrf
          <label class="reg-field"><span>Nama Usaha</span><input type="text" name="nama_usaha" placeholder="Contoh: Toko Kue Ibu Sari" required></label>
          <label class="reg-field"><span>Pemilik</span><input type="text" name="pemilik" placeholder="Nama pemilik" required></label>
          <label class="reg-field"><span>Kategori</span><select name="kategori" required><option value="">Pilih</option><option>Makanan</option><option>Kerajinan</option><option>Batik</option><option>Pertanian</option><option>Lainnya</option></select></label>
          <label class="reg-field"><span>WhatsApp</span><input type="tel" name="wa" placeholder="08xxxxxxxxxx" required></label>
          <label class="reg-field full"><span>Lokasi</span><input type="text" name="lokasi" placeholder="RT/RW atau alamat usaha" required></label>
          <label class="reg-field full"><span>Deskripsi Produk</span><textarea name="deskripsi" placeholder="Jelaskan produk dan keunggulannya" required></textarea></label>
          <div class="reg-actions"><button type="button" class="register-trigger secondary" id="cancelUmkmModalBtn">Batal</button><button class="submit-btn" type="submit">Daftarkan UMKM</button></div>
        </form>
      </div>
    </div>
  </div>
</section>

<section id="galeri" style="background:#fff;">
  <div class="container">
    <div class="section-head reveal">
      <span class="kicker">Dokumentasi</span>
      <h2>Momen-momen desa kami.</h2>
    </div>
    <div class="galeri-grid">
      @forelse($galeri as $g)
        <a class="galeri-item reveal"><img src="{{ $g->foto ? asset('storage/'.$g->foto) : 'https://picsum.photos/seed/'.$g->slug.'/500/500' }}" alt="{{ $g->nama }}"></a>
      @empty
        <p style="color:#4a564d;">Belum ada foto galeri. Tambahkan lewat panel admin (kategori: Galeri).</p>
      @endforelse
    </div>
  </div>
</section>

@if($beritas->count())
<section id="berita">
  <div class="container">
    <div class="section-head reveal">
      <span class="kicker">Kabar Desa</span>
      <h2>Berita terbaru.</h2>
    </div>
    <div class="wisata-grid">
      @foreach($beritas as $b)
        <div class="tilt-card reveal" style="height:300px;">
          <img src="{{ $b->foto ? asset('storage/'.$b->foto) : 'https://picsum.photos/seed/'.$b->slug.'/500/400' }}" alt="{{ $b->judul }}">
          <div class="tilt-info">
            <span class="tilt-tag">{{ optional($b->tanggal_terbit)->translatedFormat('d M Y') }}</span>
            <h3>{{ $b->judul }}</h3>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

@endsection

@push('scripts')
<script>
  const umkmModal = document.getElementById('umkmFormModal');
  const closeUmkmModal = () => { umkmModal?.classList.remove('show'); umkmModal?.setAttribute('aria-hidden', 'true'); };
  document.getElementById('openUmkmModalBtn')?.addEventListener('click', () => { umkmModal?.classList.add('show'); umkmModal?.setAttribute('aria-hidden', 'false'); });
  document.getElementById('closeUmkmModalBtn')?.addEventListener('click', closeUmkmModal);
  document.getElementById('cancelUmkmModalBtn')?.addEventListener('click', closeUmkmModal);
  umkmModal?.addEventListener('click', event => { if (event.target === umkmModal) closeUmkmModal(); });
</script>
@endpush
