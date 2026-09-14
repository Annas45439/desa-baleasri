@extends('layouts.app')

@section('title', 'APBDes')

@section('content')
<section style="padding: 60px 0;">
  <div class="container">
    <div class="section-head">
      <span class="kicker">APBDes</span>
      <h2>Transparansi Anggaran Desa.</h2>
      <p>Laporan Anggaran Pendapatan dan Belanja {{ $setting->nama_desa ?? 'Desa Baleasri' }}</p>
    </div>

    <div class="glass-card-white apbdes-table-desktop" style="margin-top: 36px; overflow-x:auto;">
      <table style="width:100%; border-collapse:collapse; text-align:left; font-size:0.85rem;">
        <thead>
          <tr style="border-bottom:2px solid rgba(18,32,27,0.1); color:var(--ink-main);">
            <th style="padding:12px 10px; font-family:var(--font-title); font-size:1rem;">Jenis</th>
            <th style="padding:12px 10px; font-family:var(--font-title); font-size:1rem;">Nama &amp; Rincian</th>
            <th style="padding:12px 10px; font-family:var(--font-title); font-size:1rem;">Anggaran</th>
            <th style="padding:12px 10px; font-family:var(--font-title); font-size:1rem;">Realisasi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($apbdes as $item)
            <tr style="border-bottom:1px solid rgba(18,32,27,0.06);">
              <td style="padding:12px 10px; font-weight:800; color:var(--jade-main);">{{ $item->jenis }}</td>
              <td style="padding:12px 10px;">
                <strong>{{ $item->nama }}</strong>
                @if($item->keterangan)<br><small style="color:#586b63;">{{ $item->keterangan }}</small>@endif
              </td>
              <td style="padding:12px 10px; font-weight:700;">Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td>
              <td style="padding:12px 10px; font-weight:700; color:var(--jade-main);">Rp {{ number_format($item->realisasi, 0, ',', '.') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" style="padding:30px 10px; text-align:center; color:#586b63;">Belum ada data APBDes untuk ditampilkan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="apbdes-mobile-list">
      @forelse($apbdes as $item)
        <article class="apbdes-mobile-card">
          <div class="apbdes-mobile-top">
            <span class="apbdes-mobile-type">{{ $item->jenis }}</span>
            <span class="apbdes-mobile-budget">Rp {{ number_format($item->anggaran, 0, ',', '.') }}</span>
          </div>
          <div class="apbdes-mobile-name">{{ $item->nama }}</div>
          @if($item->keterangan)
            <p class="apbdes-mobile-note">{{ $item->keterangan }}</p>
          @endif
          <div class="apbdes-mobile-bottom">
            <span>Realisasi</span>
            <strong>Rp {{ number_format($item->realisasi, 0, ',', '.') }}</strong>
          </div>
        </article>
      @empty
        <div class="apbdes-mobile-empty">Belum ada data APBDes untuk ditampilkan.</div>
      @endforelse
    </div>
  </div>
</section>
@endsection

