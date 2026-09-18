@extends('layouts.app')

@section('title', 'Halaman Kosong — Desa Baleasri')

@section('content')
<style>
/* ── Base ── */
.lost-wrap {
  min-height: 88vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 60px 20px;
  position: relative;
  overflow: hidden;
}

/* ── CSS grid-line background ── */
.lost-wrap::before {
  content: '';
  position: fixed;
  inset: 0;
  background-image:
    linear-gradient(rgba(16,185,129,.045) 1px, transparent 1px),
    linear-gradient(90deg, rgba(16,185,129,.045) 1px, transparent 1px);
  background-size: 52px 52px;
  z-index: 0;
  pointer-events: none;
}

/* ── Radial glow backdrop ── */
.lost-wrap::after {
  content: '';
  position: fixed;
  inset: 0;
  background: radial-gradient(ellipse 70% 55% at 50% 45%,
    rgba(16,185,129,.10) 0%, transparent 70%);
  z-index: 0;
  pointer-events: none;
}

/* ── Floating particles ── */
.lost-particles {
  position: fixed;
  inset: 0;
  pointer-events: none;
  z-index: 0;
  overflow: hidden;
}
.lost-particle {
  position: absolute;
  border-radius: 50%;
  opacity: 0;
  animation: particleRise linear infinite;
}
@keyframes particleRise {
  0%   { transform: translateY(110vh) scale(0); opacity: 0; }
  8%   { opacity: 1; }
  92%  { opacity: .55; }
  100% { transform: translateY(-10vh) scale(1.5); opacity: 0; }
}

/* ── Main card ── */
.lost-card {
  position: relative;
  z-index: 2;
  max-width: 680px;
  width: 100%;
  text-align: center;
}

/* ── CSS compass ring (no emoji) ── */
.lost-compass-wrap {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 10px;
  width: 96px;
  height: 96px;
  position: relative;
}
.lost-compass-wrap::before {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 50%;
  border: 2px solid transparent;
  border-top-color: #10B981;
  border-right-color: rgba(16,185,129,.35);
  animation: ringSpinCW 3s linear infinite;
  box-shadow: 0 0 20px rgba(16,185,129,.35);
}
.lost-compass-wrap::after {
  content: '';
  position: absolute;
  inset: 12px;
  border-radius: 50%;
  border: 1.5px solid transparent;
  border-bottom-color: #34D399;
  border-left-color: rgba(52,211,153,.25);
  animation: ringSpinCCW 2s linear infinite;
}
@keyframes ringSpinCW  { to { transform: rotate(360deg);  } }
@keyframes ringSpinCCW { to { transform: rotate(-360deg); } }
.lost-compass-svg {
  position: relative;
  z-index: 1;
  animation: compassPulse 3s ease-in-out infinite;
  filter: drop-shadow(0 0 10px rgba(16,185,129,.6));
}
@keyframes compassPulse {
  0%,100% { transform: scale(1) rotate(0deg); }
  33%      { transform: scale(1.08) rotate(8deg); }
  66%      { transform: scale(.96) rotate(-5deg); }
}

/* ── Glitch title ── */
.lost-title {
  font-family: var(--font-display, 'Bricolage Grotesque', sans-serif);
  font-size: clamp(2.4rem, 6.5vw, 3.8rem);
  font-weight: 900;
  line-height: 1.1;
  margin: 20px 0 14px;
  background: linear-gradient(125deg, #fff 0%, #34D399 55%, #10B981 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  position: relative;
  display: inline-block;
}
.lost-title::before,
.lost-title::after {
  content: attr(data-text);
  position: absolute;
  inset: 0;
  background: inherit;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.lost-title::before {
  animation: glitchTop 5s infinite;
  clip-path: polygon(0 0, 100% 0, 100% 38%, 0 38%);
}
.lost-title::after {
  animation: glitchBot 5s infinite;
  clip-path: polygon(0 62%, 100% 62%, 100% 100%, 0 100%);
}
@keyframes glitchTop {
  0%,88%,100% { transform: translate(0); opacity: 0; }
  89% { transform: translate(-4px,-1px); opacity: .7; }
  91% { transform: translate(4px, 1px); opacity: .6; }
  93% { transform: translate(-2px, 0); opacity: .5; }
  95% { transform: translate(0); opacity: 0; }
}
@keyframes glitchBot {
  0%,88%,100% { transform: translate(0); opacity: 0; }
  90% { transform: translate(4px, 1px); opacity: .6; }
  92% { transform: translate(-4px,-1px); opacity: .7; }
  94% { transform: translate(2px, 0); opacity: .5; }
  96% { transform: translate(0); opacity: 0; }
}

/* ── Typewriter subtitle ── */
.lost-sub {
  font-size: 1.05rem;
  color: #96A8BF;
  margin: 0 auto 36px;
  max-width: 460px;
  line-height: 1.75;
  font-weight: 500;
  min-height: 3.5em;
  display: block;
}
.tw-cursor {
  display: inline-block;
  width: 2px;
  height: 1.1em;
  background: #10B981;
  margin-left: 2px;
  vertical-align: text-bottom;
  border-radius: 2px;
  animation: twBlink .75s step-end infinite;
}
@keyframes twBlink { 50% { opacity: 0; } }

/* ── Divider ── */
.lost-divider {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 24px;
}
.lost-divider::before,
.lost-divider::after {
  content: '';
  flex: 1;
  height: 1px;
  background: rgba(16,185,129,.18);
}
.lost-divider span {
  font-size: .75rem;
  font-weight: 700;
  color: #10B981;
  letter-spacing: .1em;
  text-transform: uppercase;
  white-space: nowrap;
}

/* ── Fact cards ── */
.lost-facts {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(166px, 1fr));
  gap: 12px;
  margin-bottom: 36px;
}
.lost-fact {
  background: rgba(16,185,129,.055);
  border: 1px solid rgba(16,185,129,.16);
  border-radius: 20px;
  padding: 20px 14px 16px;
  cursor: default;
  transition: transform .3s cubic-bezier(.34,1.56,.64,1),
              border-color .3s ease,
              box-shadow .3s ease;
}
.lost-fact:hover {
  transform: translateY(-6px);
  border-color: rgba(16,185,129,.42);
  box-shadow: 0 12px 32px rgba(16,185,129,.18);
}
.lost-fact-icon { font-size: 2rem; display: block; margin-bottom: 10px; }
.lost-fact-label {
  font-size: .72rem;
  font-weight: 800;
  color: #10B981;
  text-transform: uppercase;
  letter-spacing: .07em;
  margin-bottom: 5px;
}
.lost-fact-val {
  font-size: .86rem;
  color: #BDD0E4;
  line-height: 1.45;
}

/* ── Action buttons ── */
.lost-actions {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  flex-wrap: wrap;
}
.lost-btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: linear-gradient(135deg, #10B981, #059669);
  color: #fff;
  font-weight: 800;
  font-size: .95rem;
  padding: 14px 30px;
  border-radius: 14px;
  text-decoration: none;
  box-shadow: 0 6px 24px rgba(16,185,129,.38);
  transition: transform .22s ease, box-shadow .22s ease;
  position: relative;
  overflow: hidden;
}
/* shimmer sweep */
.lost-btn-primary::before {
  content: '';
  position: absolute;
  top: 0; left: -75%;
  width: 50%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,.22), transparent);
  transform: skewX(-20deg);
  animation: shimmer 2.8s ease-in-out infinite;
}
@keyframes shimmer {
  0%   { left: -75%; }
  100% { left: 130%; }
}
.lost-btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 14px 34px rgba(16,185,129,.52);
  color: #fff;
}
.lost-btn-secondary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(255,255,255,.07);
  border: 1px solid rgba(255,255,255,.14);
  color: #EEF2FF;
  font-weight: 700;
  font-size: .92rem;
  padding: 14px 26px;
  border-radius: 14px;
  text-decoration: none;
  transition: background .2s ease, border-color .2s ease, transform .22s ease;
}
.lost-btn-secondary:hover {
  background: rgba(255,255,255,.13);
  border-color: rgba(255,255,255,.28);
  color: #fff;
  transform: translateY(-2px);
}

/* ── Footer note ── */
.lost-note {
  margin-top: 30px;
  font-size: .74rem;
  color: #374A60;
  letter-spacing: .05em;
}

/* ── Mobile ── */
@media (max-width: 520px) {
  .lost-compass-wrap { width: 72px; height: 72px; }
  .lost-title   { font-size: 2.2rem; }
  .lost-actions { flex-direction: column; width: 100%; }
  .lost-actions a { width: 100%; justify-content: center; }
}
</style>

{{-- Floating particles (rendered by JS below) --}}
<div class="lost-particles" id="lostParticles"></div>

<div class="lost-wrap">
  <div class="lost-card">

    
{{-- CSS ring compass --}}
<div class="lost-compass-wrap" aria-hidden="true">
  <svg class="lost-compass-svg" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="22" cy="22" r="20" stroke="rgba(16,185,129,.25)" stroke-width="1.5"/>
    <polygon points="22,6 25,20 22,24 19,20" fill="#10B981"/>
    <polygon points="22,38 19,24 22,20 25,24" fill="rgba(16,185,129,.4)"/>
    <polygon points="6,22 20,19 24,22 20,25" fill="rgba(255,255,255,.3)"/>
    <polygon points="38,22 24,25 20,22 24,19" fill="rgba(255,255,255,.15)"/>
    <circle cx="22" cy="22" r="2.5" fill="#fff" opacity=".9"/>
  </svg>
</div>

{{-- Glitch title --}}
<h1 class="lost-title" data-text="Hei, Nyasar Nih?">Hei, Nyasar Nih?</h1>

{{-- Typewriter subtitle --}}
<span class="lost-sub" id="lostTypewriter"><span class="tw-cursor"></span></span>

{{-- Section divider --}}
<div class="lost-divider"><span>Serba-serbi Desa Baleasri</span></div>

{{-- Village fact cards --}}
<div class="lost-facts">
  <div class="lost-fact">
    <span class="lost-fact-icon" aria-hidden="true">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 20l4-8 4 4 4-7 4 11"/><line x1="3" y1="20" x2="21" y2="20"/>
      </svg>
    </span>
    <div class="lost-fact-label">Lokasi</div>
    <div class="lost-fact-val">Lereng Gunung Lawu, Kab. Magetan, Jawa Timur</div>
  </div>
  <div class="lost-fact">
    <span class="lost-fact-icon" aria-hidden="true">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M2 12c1.5-3 3-4.5 5-4.5s3.5 3 5.5 3 3.5-3 5.5-3 3 2 3 2"/>
        <path d="M2 17c1.5-3 3-4.5 5-4.5s3.5 3 5.5 3 3.5-3 5.5-3 3 2 3 2"/>
      </svg>
    </span>
    <div class="lost-fact-label">Wisata</div>
    <div class="lost-fact-val">Embung Duwetsewu — spot foto terbaik di sini</div>
  </div>
  <div class="lost-fact">
    <span class="lost-fact-icon" aria-hidden="true">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="18" height="18" rx="3"/>
        <circle cx="8.5" cy="8.5" r="1.5"/><circle cx="15.5" cy="8.5" r="1.5"/>
        <path d="M3 15l5-5 4 4 3-3 5 5"/>
      </svg>
    </span>
    <div class="lost-fact-label">UMKM Unggulan</div>
    <div class="lost-fact-val">Batik Gedhek khas Baleasri, motif unik asli desa</div>
  </div>
</div>

{{-- Buttons --}}
<div class="lost-actions">
  <a href="{{ route('home') }}" class="lost-btn-primary">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
    Balik ke Beranda
  </a>
  <a href="{{ route('wisata.index') }}" class="lost-btn-secondary">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a7 7 0 0 1 7 7c0 5-7 13-7 13S5 14 5 9a7 7 0 0 1 7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
    Jelajahi Wisata
  </a>
</div>

<p class="lost-note">Desa Baleasri &bull; KKNT UNESA 2026</p>
</div>
</div>

<script>
(function () {
  /* ── Floating particles ── */
  const wrap = document.getElementById('lostParticles');
  const colors = ['#10B981','#34D399','#6EE7B7','#059669','#A7F3D0','#D1FAE5'];
  for (let i = 0; i < 45; i++) {
    const el = document.createElement('div');
    el.className = 'lost-particle';
    const s = Math.random() * 7 + 2;
    el.style.cssText = [
      `width:${s}px`,
      `height:${s}px`,
      `left:${Math.random() * 100}%`,
      `bottom:${Math.random() * -20}%`,
      `background:${colors[Math.floor(Math.random() * colors.length)]}`,
      `animation-duration:${7 + Math.random() * 11}s`,
      `animation-delay:${Math.random() * 9}s`,
    ].join(';');
    wrap.appendChild(el);
  }

  /* ── Typewriter ── */
  const phrases = [
    'Halaman ini memang kosong, nggak ada isinya.',
    'Tapi Desa Baleasri punya banyak hal keren buat dijelajahi.',
    'Yuk, kita balik ke jalan yang bener.',
    'Mampir ke wisata atau cek produk UMKM kita.',
  ];
  const tw  = document.getElementById('lostTypewriter');
  const cur = document.createElement('span');
  cur.className = 'tw-cursor';
  let pi = 0, ci = 0, del = false, hold = 0;

  function tick () {
    const txt = phrases[pi];
    if (!del) {
      ci++;
      tw.textContent = txt.slice(0, ci);
      tw.appendChild(cur);
      if (ci >= txt.length) { del = true; hold = 55; }
      setTimeout(tick, 48);
    } else {
      if (hold-- > 0) { setTimeout(tick, 30); return; }
      ci--;
      tw.textContent = txt.slice(0, ci);
      tw.appendChild(cur);
      if (ci <= 0) { del = false; pi = (pi + 1) % phrases.length; }
      setTimeout(tick, 20);
    }
  }
  tick();
})();
</script>
@endsection
