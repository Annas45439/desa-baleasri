@extends('layouts.app')

@section('title', !empty($query) ? 'Hasil Pencarian: "' . $query . '" — Desa Baleasri' : 'Pencarian Pintar Desa Baleasri')

@section('content')
<section style="padding: 50px 0 80px;">
  <div class="container">
    
    <!-- Search Form Header -->
    <div class="glass-card-white" style="margin-bottom: 32px; padding: 32px 28px;">
      <div style="max-width: 720px; margin: 0 auto; text-align: center;">
        <span class="kicker" style="justify-content: center; margin-bottom: 8px;">🔍 Layanan &amp; Informasi Desa</span>
        <h2 style="font-family: var(--font-title); font-size: 1.8rem; font-weight: 800; color: var(--ink-main); margin-bottom: 16px;">
          @if(!empty($query))
            Hasil Pencarian untuk "<span style="color: var(--jade-main);">{{ $query }}</span>"
          @else
            Pencarian Pintar Desa Baleasri
          @endif
        </h2>

        <!-- Search Bar Form -->
        <form action="{{ route('search') }}" method="GET" style="position: relative; margin-top: 20px;">
          <div style="display: flex; gap: 10px; background: rgba(18,32,27,0.04); padding: 6px; border-radius: 99px; border: 2px solid rgba(13,138,108,0.3);">
            <div style="display: flex; align-items: center; padding-left: 16px; color: var(--jade-main);">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>
            <input type="text" name="q" value="{{ $query }}" placeholder="Ketik kata kunci (contoh: Surat Domisili, Batik Gedhek, Embung, Bansos)..." style="flex-grow: 1; border: none; background: transparent; outline: none; font-size: 0.95rem; font-family: var(--font-body); color: var(--ink-main); font-weight: 600;" required>
            <button type="submit" class="btn btn-primary" style="border-radius: 99px; padding: 10px 24px; font-weight: 700; white-space: nowrap;">Cari Instan</button>
          </div>
        </form>

        <div style="margin-top: 14px; font-size: 0.78rem; color: #586b63; display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; align-items: center;">
          <span style="font-weight: 700;">Kata kunci populer:</span>
          <a href="{{ route('search', ['q' => 'Surat Domisili']) }}" style="color: var(--jade-main); font-weight: 600; text-decoration: underline;">Surat Domisili</a>
          <span>&bull;</span>
          <a href="{{ route('search', ['q' => 'Surat Keterangan Usaha']) }}" style="color: var(--jade-main); font-weight: 600; text-decoration: underline;">Surat SKU</a>
          <span>&bull;</span>
          <a href="{{ route('search', ['q' => 'Embung Duwetsewu']) }}" style="color: var(--jade-main); font-weight: 600; text-decoration: underline;">Embung</a>
          <span>&bull;</span>
          <a href="{{ route('search', ['q' => 'Batik Gedhek']) }}" style="color: var(--jade-main); font-weight: 600; text-decoration: underline;">Batik Gedhek</a>
          <span>&bull;</span>
          <a href="{{ route('search', ['q' => 'Bansos']) }}" style="color: var(--jade-main); font-weight: 600; text-decoration: underline;">Bansos</a>
        </div>
      </div>
    </div>

    @if(!empty($query))
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <p style="font-size: 0.9rem; color: #4e5d56; margin: 0;">
          Ditemukan <strong style="color: var(--ink-main);">{{ $totalCount }}</strong> hasil terkait kata kunci Anda.
        </p>
      </div>

      @if($totalCount === 0)
        <div class="glass-card-white" style="text-align: center; padding: 48px 24px;">
          <div style="width: 64px; height: 64px; background: rgba(225,29,72,0.1); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: #e11d48; margin-bottom: 16px;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
          </div>
          <h3 style="font-family: var(--font-title); font-size: 1.25rem; font-weight: 800; color: var(--ink-main); margin-bottom: 8px;">Tidak Ada Hasil Yang Cocok</h3>
          <p style="font-size: 0.88rem; color: #586b63; max-width: 480px; margin: 0 auto 20px;">
            Maaf, kami tidak dapat menemukan informasi dengan kata kunci "<strong>{{ $query }}</strong>". Coba gunakan istilah atau ejaan yang lebih umum.
          </p>
          <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('letters.index') }}" class="btn btn-outline" style="border-radius: 99px;">Ajukan Surat Online</a>
            <a href="{{ route('pengaduan.public') }}" class="btn btn-outline" style="border-radius: 99px;">Lapor Pengaduan</a>
            <a href="{{ route('home') }}" class="btn btn-primary" style="border-radius: 99px;">Kembali ke Beranda</a>
          </div>
        </div>
      @else

        <!-- 1. Layanan Surat & Informasi Desa -->
        @if(count($suratResults) > 0)
          <div style="margin-bottom: 36px;">
            <h3 style="font-family: var(--font-title); font-size: 1.2rem; font-weight: 800; color: var(--ink-main); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
              <span style="width: 10px; height: 10px; background: var(--jade-main); border-radius: 50%; display: inline-block;"></span>
              Layanan Surat &amp; Informasi Publik ({{ count($suratResults) }})
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px;">
              @foreach($suratResults as $item)
                <div class="glass-card-white" style="display: flex; flex-direction: column; justify-content: space-between; border-left: 4px solid var(--jade-main);">
                  <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                      <span style="font-size: 0.7rem; font-weight: 800; background: rgba(13,138,108,0.12); color: var(--jade-main); padding: 3px 10px; border-radius: 99px; text-transform: uppercase;">{{ $item['badge'] }}</span>
                    </div>
                    <h4 style="font-family: var(--font-title); font-size: 1.05rem; font-weight: 800; color: var(--ink-main); margin-bottom: 6px;">{{ $item['nama'] }}</h4>
                    <p style="font-size: 0.83rem; color: #4e5d56; line-height: 1.5; margin-bottom: 16px;">{{ $item['deskripsi'] }}</p>
                  </div>
                  <a href="{{ $item['url'] }}" class="btn btn-outline" style="width: 100%; text-align: center; border-radius: 12px; font-weight: 700; font-size: 0.82rem; padding: 8px 14px;">Buka Layanan &rarr;</a>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        <!-- 2. Potensi, Wisata & UMKM Desa -->
        @if($potensiResults->count() > 0)
          <div style="margin-bottom: 36px;">
            <h3 style="font-family: var(--font-title); font-size: 1.2rem; font-weight: 800; color: var(--ink-main); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
              <span style="width: 10px; height: 10px; background: #f59e0b; border-radius: 50%; display: inline-block;"></span>
              Potensi, Wisata &amp; Produk UMKM ({{ $potensiResults->count() }})
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
              @foreach($potensiResults as $p)
                <div class="glass-card-white" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                  <div style="height: 160px; position: relative; background: #eee;">
                    <img src="{{ storage_image_url($p->foto) }}" alt="{{ $p->nama }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <span style="position: absolute; top: 10px; left: 10px; font-size: 0.68rem; font-weight: 800; background: rgba(18,32,27,0.8); color: #fff; padding: 3px 10px; border-radius: 99px;">{{ ucfirst($p->kategori) }}</span>
                  </div>
                  <div style="padding: 16px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                      <h4 style="font-family: var(--font-title); font-size: 1rem; font-weight: 800; color: var(--ink-main); margin-bottom: 6px;">{{ $p->nama }}</h4>
                      <p style="font-size: 0.82rem; color: #4e5d56; line-height: 1.5; margin-bottom: 14px;">{{ \Illuminate\Support\Str::limit(strip_tags($p->deskripsi), 90) }}</p>
                    </div>
                    @if($p->kategori === 'umkm')
                      <a href="{{ route('orders.create', $p) }}" class="btn btn-primary" style="width: 100%; text-align: center; border-radius: 12px; font-weight: 700; font-size: 0.82rem; padding: 8px;">Pesan Produk</a>
                    @else
                      <a href="{{ route('wisata') }}" class="btn btn-outline" style="width: 100%; text-align: center; border-radius: 12px; font-weight: 700; font-size: 0.82rem; padding: 8px;">Lihat Destinasi</a>
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        <!-- 3. Berita Desa -->
        @if($beritaResults->count() > 0)
          <div>
            <h3 style="font-family: var(--font-title); font-size: 1.2rem; font-weight: 800; color: var(--ink-main); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
              <span style="width: 10px; height: 10px; background: #3b82f6; border-radius: 50%; display: inline-block;"></span>
              Berita &amp; Artikel Desa ({{ $beritaResults->count() }})
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px;">
              @foreach($beritaResults as $b)
                <div class="glass-card-white" style="display: flex; gap: 14px; padding: 14px;">
                  <div style="width: 90px; height: 90px; flex-shrink: 0; border-radius: 12px; overflow: hidden; background: #eee;">
                    <img src="{{ storage_image_url($b->foto) }}" alt="{{ $b->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                  </div>
                  <div style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                      <span style="font-size: 0.7rem; color: #586b63; font-weight: 600;">{{ $b->created_at ? $b->created_at->format('d M Y') : 'Terbaru' }}</span>
                      <h4 style="font-family: var(--font-title); font-size: 0.95rem; font-weight: 800; color: var(--ink-main); margin: 2px 0 4px; line-height: 1.3;">{{ $b->judul }}</h4>
                    </div>
                    <a href="{{ route('berita.public') }}#berita-{{ $b->id }}" style="font-size: 0.78rem; font-weight: 700; color: var(--jade-main); text-decoration: none;">Baca Berita &rarr;</a>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif

      @endif
    @endif
  </div>
</section>
@endsection
