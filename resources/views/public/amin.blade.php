@extends('layouts.app')

@section('title', 'Cari Apa Sih Bangg? 🧐')

@section('content')
<style>
.amin-hero-container {
  min-height: 82vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px 20px;
  position: relative;
}
.amin-card {
  background: rgba(15, 24, 37, 0.85);
  border: 1px solid rgba(16, 185, 129, 0.25);
  border-radius: 28px;
  padding: 48px 36px;
  max-width: 640px;
  width: 100%;
  text-align: center;
  box-shadow: 0 24px 60px rgba(0, 0, 0, 0.60), inset 0 1px 0 rgba(255, 255, 255, 0.10);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  position: relative;
  overflow: hidden;
  animation: floatCard 4s ease-in-out infinite alternate;
}
@keyframes floatCard {
  0% { transform: translateY(0px); }
  100% { transform: translateY(-8px); }
}
.amin-card::before {
  content: '';
  position: absolute;
  top: -80px;
  right: -80px;
  width: 220px;
  height: 220px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(16, 185, 129, 0.22), transparent 70%);
  pointer-events: none;
}
.amin-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(245, 158, 11, 0.12);
  border: 1px solid rgba(245, 158, 11, 0.30);
  color: var(--gold, #F59E0B);
  font-size: 0.76rem;
  font-weight: 800;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  padding: 6px 16px;
  border-radius: 999px;
  margin-bottom: 22px;
}
.amin-title {
  font-family: var(--font-display, 'Bricolage Grotesque', sans-serif);
  font-size: clamp(2rem, 5vw, 2.8rem);
  font-weight: 800;
  color: #ffffff;
  line-height: 1.2;
  margin-bottom: 16px;
  background: linear-gradient(135deg, #FFFFFF 0%, #10B981 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.amin-subtitle {
  font-size: 1.05rem;
  color: #C8D3E8;
  line-height: 1.65;
  margin-bottom: 30px;
  font-weight: 500;
}
.amin-fun-quote {
  background: rgba(255, 255, 255, 0.04);
  border: 1px dashed rgba(255, 255, 255, 0.12);
  border-radius: 18px;
  padding: 18px 20px;
  margin-bottom: 32px;
  font-size: 0.9rem;
  color: #8A9BBB;
  line-height: 1.6;
}
.amin-actions {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 14px;
  flex-wrap: wrap;
}
.amin-btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: linear-gradient(135deg, #10B981 0%, #059669 100%);
  color: #ffffff;
  font-weight: 800;
  font-size: 0.95rem;
  padding: 14px 28px;
  border-radius: 14px;
  text-decoration: none;
  box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
  transition: transform 0.22s ease, box-shadow 0.22s ease;
}
.amin-btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 28px rgba(16, 185, 129, 0.50);
  color: #ffffff;
}
.amin-btn-secondary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.15);
  color: #F0F4FC;
  font-weight: 700;
  font-size: 0.92rem;
  padding: 14px 24px;
  border-radius: 14px;
  text-decoration: none;
  transition: background 0.2s ease, border-color 0.2s ease;
}
.amin-btn-secondary:hover {
  background: rgba(255, 255, 255, 0.14);
  border-color: rgba(255, 255, 255, 0.30);
  color: #ffffff;
}
@media (max-width: 640px) {
  .amin-card { padding: 32px 20px; }
  .amin-actions { flex-direction: column; width: 100%; }
  .amin-actions a { width: 100%; justify-content: center; }
}
</style>

<div class="amin-hero-container">
  <div class="amin-card">
    <div class="amin-badge">
      <span>🕵️ Jalur Rahasia Terdeteksi</span>
    </div>

    <h1 class="amin-title">Cari Apa Sih Bangg? 🧐</h1>

    <p class="amin-subtitle">
      Niat banget ngetik <code>/amin</code> wkwk... Penasaran banget ya sama panel kelola Desa Baleasri? Jalurnya bukan di sini bangg 😜
    </p>

    <div class="amin-fun-quote">
      💡 <strong>Did You Know?</strong><br>
      Daripada stalking jalan tikus, mending jalan-jalan ke <strong>Embung Duwetsewu</strong> atau borong produk <strong>UMKM Batik Gedhek</strong> asli Desa Baleasri!
    </div>

    <div class="amin-actions">
      <a href="{{ route('home') }}" class="amin-btn-primary">
        &larr; Kembali ke Beranda
      </a>
      <a href="{{ route('umkm.index') }}" class="amin-btn-secondary">
        🌾 Jelajahi Wisata &amp; UMKM
      </a>
    </div>
  </div>
</div>
@endsection
