@extends('layouts.app')

@section('title', 'APBDes')

@php
  $types = ['Pendapatan', 'Belanja', 'Pembiayaan'];
  $totals = collect($types)->mapWithKeys(function ($type) use ($apbdes) {
      $items = $apbdes->where('jenis', $type);
      return [$type => [
          'anggaran' => (float) $items->sum('anggaran'),
          'realisasi' => (float) $items->sum('realisasi'),
          'count' => $items->count(),
      ]];
  });
  $totalBudget = (float) $apbdes->sum('anggaran');
  $totalRealization = (float) $apbdes->sum('realisasi');
  $realizationRate = $totalBudget > 0 ? min(100, ($totalRealization / $totalBudget) * 100) : 0;
  $maxItemBudget = max((float) $apbdes->max('anggaran'), 1);
  $compositionTotal = max($totals->sum('anggaran'), 1);
@endphp

@section('content')
<section style="padding:60px 0;">
  <div class="container">
    <div class="section-head">
      <span class="kicker">APBDes {{ $selectedYear }}</span>
      <h2>Transparansi Anggaran Desa.</h2>
      <p>Ringkasan pendapatan, belanja, pembiayaan, dan realisasi {{ $setting->nama_desa ?? 'Desa Baleasri' }}.</p>
    </div>

    <div class="apbdes-year-picker" style="display:flex; justify-content:flex-end; align-items:center; gap:10px; margin-top:24px;">
      <label for="apbdes-year" style="font-weight:700; color:var(--ink-sub);">Tahun anggaran</label>
      <select id="apbdes-year" onchange="if(this.value) window.location='{{ route('apbdes.public') }}?tahun='+this.value;" style="border:1px solid var(--glass-border); border-radius:999px; padding:10px 16px; background:var(--surface-glass); color:var(--ink-main); font:600 .85rem var(--font-body);">
        @forelse($years as $year)
          <option value="{{ $year }}" @selected($year == $selectedYear)>{{ $year }}</option>
        @empty
          <option value="{{ $selectedYear }}">{{ $selectedYear }}</option>
        @endforelse
      </select>
    </div>

    <div class="apbdes-summary-grid" style="margin-top:28px;">
      @foreach($types as $type)
        <article class="apbdes-summary-card">
          <span class="apbdes-summary-label">{{ $type }}</span>
          <strong>Rp {{ number_format($totals[$type]['anggaran'], 0, ',', '.') }}</strong>
          <small>{{ $totals[$type]['count'] }} pos &bull; Realisasi Rp {{ number_format($totals[$type]['realisasi'], 0, ',', '.') }}</small>
        </article>
      @endforeach
      <article class="apbdes-summary-card apbdes-summary-card--highlight">
        <span class="apbdes-summary-label">Realisasi Keseluruhan</span>
        <strong>{{ number_format($realizationRate, 1, ',', '.') }}%</strong>
        <small>Rp {{ number_format($totalRealization, 0, ',', '.') }} dari Rp {{ number_format($totalBudget, 0, ',', '.') }}</small>
      </article>
    </div>

    @if($apbdes->isNotEmpty())
      <div class="apbdes-chart-grid" style="margin-top:24px;">
        <article class="apbdes-chart-card">
          <div class="apbdes-chart-head">
            <div><span class="kicker">Perbandingan</span><h3>Anggaran vs Realisasi</h3></div>
            <div class="apbdes-legend"><span><i class="legend-budget"></i>Anggaran</span><span><i class="legend-realization"></i>Realisasi</span></div>
          </div>
          <div class="apbdes-bars">
            @foreach($types as $type)
              @php
                $budget = $totals[$type]['anggaran'];
                $realization = $totals[$type]['realisasi'];
              @endphp
              <div class="apbdes-bar-row">
                <span>{{ $type }}</span>
                <div class="apbdes-bar-track"><i class="apbdes-bar-budget" style="width:{{ $budget > 0 ? max(3, ($budget / $maxItemBudget) * 100) : 0 }}%"></i><i class="apbdes-bar-realization" style="width:{{ $budget > 0 ? min(100, ($realization / $maxItemBudget) * 100) : 0 }}%"></i></div>
                <b>Rp {{ number_format($budget, 0, ',', '.') }}</b>
              </div>
            @endforeach
          </div>
          <p class="apbdes-chart-note">Panjang batang menunjukkan nilai anggaran; batang hijau menunjukkan bagian yang sudah terealisasi.</p>
        </article>

        <article class="apbdes-chart-card">
          <div class="apbdes-chart-head"><div><span class="kicker">Komposisi</span><h3>Porsi Anggaran</h3></div></div>
          <div class="apbdes-donut-wrap">
            <div class="apbdes-donut" style="--income:{{ ($totals['Pendapatan']['anggaran'] / $compositionTotal) * 100 }}%; --spending:{{ (($totals['Pendapatan']['anggaran'] + $totals['Belanja']['anggaran']) / $compositionTotal) * 100 }}%;"></div>
            <div class="apbdes-donut-center"><strong>100%</strong><span>Total pos</span></div>
          </div>
          <div class="apbdes-composition-list">
            @foreach($types as $type)
              <div><span><i class="composition-dot composition-dot--{{ strtolower($type) }}"></i>{{ $type }}</span><strong>{{ number_format(($totals[$type]['anggaran'] / $compositionTotal) * 100, 1, ',', '.') }}%</strong></div>
            @endforeach
          </div>
        </article>
      </div>

      <article class="apbdes-chart-card" style="margin-top:24px;">
        <div class="apbdes-chart-head">
          <div><span class="kicker">Rincian</span><h3>Pos Anggaran dan Progres Realisasi</h3></div>
          <span class="apbdes-total-badge">Total {{ $apbdes->count() }} pos</span>
        </div>
        <div class="apbdes-detail-list">
          @foreach($apbdes as $item)
            @php $itemRate = $item->anggaran > 0 ? min(100, ($item->realisasi / $item->anggaran) * 100) : 0; @endphp
            <div class="apbdes-detail-row">
              <div class="apbdes-detail-title"><span class="apbdes-type-pill">{{ $item->jenis }}</span><strong>{{ $item->nama }}</strong>@if($item->keterangan)<small>{{ $item->keterangan }}</small>@endif</div>
              <div class="apbdes-detail-values"><span>Anggaran <b>Rp {{ number_format($item->anggaran, 0, ',', '.') }}</b></span><span>Realisasi <b>Rp {{ number_format($item->realisasi, 0, ',', '.') }}</b></span></div>
              <div class="apbdes-progress"><i style="width:{{ $itemRate }}%"></i></div>
              <strong class="apbdes-progress-label">{{ number_format($itemRate, 1, ',', '.') }}%</strong>
            </div>
          @endforeach
        </div>
      </article>
    @else
      <div class="glass-card-white" style="margin-top:28px; padding:36px; text-align:center; color:var(--ink-muted);">Belum ada data APBDes untuk tahun {{ $selectedYear }}.</div>
    @endif
  </div>
</section>
@endsection
