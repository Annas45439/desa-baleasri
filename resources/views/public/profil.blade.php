@extends('layouts.app')

@section('title', 'Profil & Sejarah Desa Baleasri')

@section('content')
<section style="padding: 60px 0;">
  <div class="container">
    <!-- Header Section -->
    <div class="section-head" style="margin-bottom: 32px;">
      <span class="kicker">Profil &amp; Sejarah Resmi</span>
      <h2>Desa Baleasri, Kecamatan Ngariboyo</h2>
      <p>Kabupaten Magetan, Provinsi Jawa Timur &mdash; Tempat bermukim yang indah, tenteram, dan harmonis.</p>
    </div>

    <!-- Identitas & Pejabat Desa -->
    <div class="glass-card-white" style="margin-bottom: 36px;">
      <div class="sambutan-flex">
        <div class="kades-avatar-frame">
          @if($setting->foto_kepala_desa)
            <img src="{{ asset('storage/'.$setting->foto_kepala_desa) }}" alt="{{ $setting->nama_kepala_desa ?? 'Kepala Desa' }}">
          @else
            <img src="https://picsum.photos/seed/kadesbaleasri/400/530" alt="Kepala Desa Baleasri">
          @endif
        </div>
        <div style="flex-grow:1;">
          <div class="kicker" style="margin-bottom:8px;">Pemerintahan Desa</div>
          <h3 style="font-family:var(--font-title); font-weight:800; font-size:1.5rem; margin-bottom:4px; color:var(--ink-main);">
            {{ $setting->nama_kepala_desa ?? 'Juremi' }}
          </h3>
          <p style="font-size:0.85rem; color:var(--jade-main); font-weight:700; margin-bottom:14px;">
            Kepala Desa Baleasri &bull; Penanggung Jawab Pemerintahan
          </p>
          <div class="sambutan-quote-box">
            â€œ{{ $setting->sambutan ?: 'Desa Baleasri menjunjung tinggi kearifan lokal, semangat gotong royong, dan transparansi pelayanan publik demi mewujudkan desa yang mandiri, sejahtera, serta berdaya saing.' }}â€
          </div>
          <div style="display:flex; flex-wrap:wrap; gap:16px; margin-top:16px; font-size:0.8rem; color:#4e5d56;">
            <span><strong>Sekretaris Desa:</strong> Tri Anjono</span>
            <span>&bull;</span>
            <span><strong>Status Data:</strong> Prodeskel Kemendagri 2025</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Sejarah / Asal Usul Desa Baleasri -->
    <div class="glass-card-white" style="margin-bottom: 36px;">
      <div class="section-head" style="margin-bottom: 24px;">
        <span class="kicker">Asal Usul &amp; Babad Desa</span>
        <h2>Sejarah Desa Baleasri</h2>
        <p>Catatan sejarah pembentukan dan babad wilayah Desa Baleasri, Kecamatan Ngariboyo, Kabupaten Magetan.</p>
      </div>

      <div style="font-size:0.95rem; color:#3a473f; line-height:1.8; display:flex; flex-direction:column; gap:20px;">
        <div>
          <h3 style="font-family:var(--font-title); font-size:1.25rem; font-weight:800; color:var(--ink-main); margin-bottom:8px;">Letak &amp; Gambaran Umum</h3>
          <p>
            Kurang lebih 4 km di sebelah selatan Kota Magetan terdapat sebuah desa yang cukup luas kawasannya, dengan suasana relatif tenang karena didukung oleh penduduk yang agamis â€” hampir seluruh warganya beragama Islam. Itulah <strong>Desa Baleasri</strong>.
          </p>
          <p style="margin-top:8px;">
            Dahulu Desa Baleasri masuk wilayah Kecamatan Magetan. Namun karena adanya pemekaran wilayah kecamatan, kini Desa Baleasri resmi menjadi bagian dari <strong>Kecamatan Ngariboyo</strong>, Kabupaten Magetan.
          </p>
        </div>

        <!-- Batas Wilayah -->
        <div style="background:var(--jade-soft); border:1px solid rgba(13,138,108,0.2); padding:20px; border-radius:20px;">
          <h4 style="font-family:var(--font-title); font-size:1.05rem; font-weight:800; color:var(--ink-main); margin-bottom:12px;">Batas-Batas Wilayah Desa Baleasri</h4>
          <div class="profil-boundary-grid">
            <div style="background:#fff; padding:12px; border-radius:12px; border:1px solid rgba(18,32,27,0.06);">
              <span style="font-size:0.72rem; font-weight:800; color:var(--jade-main); text-transform:uppercase;">Utara</span>
              <div style="font-weight:700; font-size:0.85rem; margin-top:2px;">Desa Sumberdukun</div>
            </div>
            <div style="background:#fff; padding:12px; border-radius:12px; border:1px solid rgba(18,32,27,0.06);">
              <span style="font-size:0.72rem; font-weight:800; color:var(--jade-main); text-transform:uppercase;">Timur</span>
              <div style="font-weight:700; font-size:0.85rem; margin-top:2px;">Desa Ngariboyo</div>
            </div>
            <div style="background:#fff; padding:12px; border-radius:12px; border:1px solid rgba(18,32,27,0.06);">
              <span style="font-size:0.72rem; font-weight:800; color:var(--jade-main); text-transform:uppercase;">Selatan</span>
              <div style="font-weight:700; font-size:0.85rem; margin-top:2px;">Desa Selotinatah</div>
            </div>
            <div style="background:#fff; padding:12px; border-radius:12px; border:1px solid rgba(18,32,27,0.06);">
              <span style="font-size:0.72rem; font-weight:800; color:var(--jade-main); text-transform:uppercase;">Barat</span>
              <div style="font-weight:700; font-size:0.85rem; margin-top:2px;">Desa Selopanggung</div>
            </div>
          </div>
        </div>

        <!-- 5 Kyai Cikal Bakal -->
        <div>
          <h3 style="font-family:var(--font-title); font-size:1.25rem; font-weight:800; color:var(--ink-main); margin-bottom:8px;">Lima Tokoh/Kyai Cikal Bakal Babad Desa</h3>
          <p style="margin-bottom:12px;">Berdasarkan penuturan sejarah Bapak <strong>Darmo Sukir (alm.)</strong>, mantan Kamituwo Baleasri selama 43 tahun, terdapat lima tokoh/kyai cikal bakal yang pertama kali membuka lahan dan membabat wilayah Baleasri:</p>
          <div class="misi-glass-grid">
            <div class="misi-glass-card"><div class="num">1</div><div class="txt"><strong>Kyai Wongso Wijoyo</strong> (Gusti Brotokusumo)</div></div>
            <div class="misi-glass-card"><div class="num">2</div><div class="txt"><strong>Kyai Jamaludin</strong></div></div>
            <div class="misi-glass-card"><div class="num">3</div><div class="txt"><strong>Kyai Rawun</strong></div></div>
            <div class="misi-glass-card"><div class="num">4</div><div class="txt"><strong>Kyai Bagus Reso</strong></div></div>
            <div class="misi-glass-card" style="grid-column: 1 / -1;"><div class="num">5</div><div class="txt"><strong>Kyai Nurdiyah</strong></div></div>
          </div>
        </div>

        <!-- Rincian Wilayah Asal -->
        <div>
          <h3 style="font-family:var(--font-title); font-size:1.25rem; font-weight:800; color:var(--ink-main); margin-bottom:12px;">Babad Tiga Wilayah Asal</h3>
          
          <div style="display:flex; flex-direction:column; gap:16px;">
            <div style="background:rgba(255,255,255,0.7); padding:16px 20px; border-radius:18px; border:1px solid rgba(18,32,27,0.06);">
              <h4 style="font-family:var(--font-title); font-weight:800; color:var(--ink-main); font-size:1rem; margin-bottom:6px;">1. Kelurahan Ngemplak / Ngambaan</h4>
              <p style="font-size:0.88rem; line-height:1.7;">
                Meliputi wilayah Karang, Wareng, dan Jajar. Dahulu kawasan ini berupa hutan angker dengan pepatah kuno <em>"janmo moro janmo mati, sato moro sato mati"</em> (siapa pun yang datang akan tertimpa musibah). Kawasan yang sangat wingit ini kemudian <strong>"ditambak"</strong> (ditulak balak) oleh <strong>Kyai Jamaluddin</strong> sehingga menjadi aman dan tidak angker lagi. Dari istilah <strong>TAMBAK &rarr; Ngambak</strong>, kawasan ini dinamakan <strong>Ngambakan</strong>, dengan Lurah pertama bernama Ismangil.
              </p>
            </div>

            <div style="background:rgba(255,255,255,0.7); padding:16px 20px; border-radius:18px; border:1px solid rgba(18,32,27,0.06);">
              <h4 style="font-family:var(--font-title); font-weight:800; color:var(--ink-main); font-size:1rem; margin-bottom:6px;">2. Kelurahan Bendo Sewu / Duwet Sewu</h4>
              <p style="font-size:0.88rem; line-height:1.7;">
                Meliputi Mendak, Titang, Gambiran, Oro-oro, Bendosewu/Duwetsewu, Manding, dan Dawung.
              </p>
              <ul style="font-size:0.88rem; line-height:1.7; margin-top:8px; padding-left:20px; display:flex; flex-direction:column; gap:6px;">
                <li><strong>Dukuh Mendak:</strong> Dibabat oleh <strong>Kyai Bagus Reso</strong>, bangsawan Surakarta pengikut Perang Diponegoro yang berobat di wilayah ini setelah pendhok/mendhak kerisnya hilang (terucap <em>"Mendhak keris saya hilang!"</em>).</li>
                <li><strong>Dukuh Duwetsewu:</strong> Berasal dari banyaknya pohon buah <strong>Duwet</strong> yang lebat dan disukai warga serta burung.</li>
                <li><strong>Dukuh Manding:</strong> Dibabat oleh <strong>Kyai Rawun</strong> yang senantiasa mendekatkan diri (Jawa: <em>sumandhing</em>) kepada Tuhan Yang Maha Kuasa saat membabat hutan.</li>
              </ul>
            </div>

            <div style="background:rgba(255,255,255,0.7); padding:16px 20px; border-radius:18px; border:1px solid rgba(18,32,27,0.06);">
              <h4 style="font-family:var(--font-title); font-weight:800; color:var(--ink-main); font-size:1rem; margin-bottom:6px;">3. Dukuh Ngeleng &amp; Makam Jabung</h4>
              <p style="font-size:0.88rem; line-height:1.7;">
                Cikal bakal Dukuh Ngeleng adalah <strong>R. Wongso Wijoyo (Broto Kusumo / Kyai Ageng Ngeleng)</strong>. Beliau membabat dan membenahi hutan secara mengagumkan dalam waktu sangat singkat (Jawa: <em>mung sa' lengan</em> &rarr; <strong>Ngeleng</strong>). Beliau dimakamkan di <strong>Makam Jabung Ngeleng</strong>, yang hingga kini menjadi pusat ziarah silaturahmi tahunan kerabat <strong>PAKEM JABUNG NGELENG</strong>. Meliputi wilayah Krukungan, Bandhut, Bangak, dan Slungguh.
              </p>
            </div>
          </div>
        </div>

        <!-- Penggabungan 1887 & Arti Nama -->
        <div style="background:linear-gradient(135deg, var(--jade-dark), #24513f); color:#ffffff; padding:24px; border-radius:24px; box-shadow:0 14px 30px rgba(18,32,27,0.15);">
          <div style="font-size:0.75rem; font-weight:800; color:var(--gold-main); text-transform:uppercase; letter-spacing:0.08em; margin-bottom:6px;">Peristiwa Sejarah 1887</div>
          <h3 style="font-family:var(--font-title); font-size:1.35rem; font-weight:800; margin-bottom:10px;">Penggabungan Menjadi Desa Baleasri</h3>
          <p style="font-size:0.9rem; opacity:0.9; line-height:1.7;">
            Pada tahun <strong>1887</strong>, ketika Bupati Magetan dijabat oleh <strong>Raden Aryo Kertohadinegoro</strong> (terkenal dengan sebutan Gusti Ridder / Gusti Lider), dua kelurahan dan satu dukuhan tersebut digabungkan secara resmi menjadi satu desa dan diberi nama <strong>BALEASRI</strong>.
          </p>
          <div style="display:flex; gap:16px; margin-top:14px; font-family:var(--font-title); font-weight:700; font-size:0.95rem; border-top:1px solid rgba(255,255,255,0.15); padding-top:12px;">
            <span><strong>Bale (Balai):</strong> Tempat / Rumah</span>
            <span>+</span>
            <span><strong>Asri:</strong> Indah, Tenteram &amp; Harmonis</span>
          </div>
        </div>

        <!-- Silsilah Lurah -->
        <div>
          <h3 style="font-family:var(--font-title); font-size:1.25rem; font-weight:800; color:var(--ink-main); margin-bottom:12px;">Daftar Kepala Desa / Lurah Baleasri Dari Masa ke Masa</h3>
          <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; text-align:left; font-size:0.85rem;">
              <thead>
                <tr style="border-bottom:2px solid var(--ink-main); color:var(--ink-main);">
                  <th style="padding:10px; font-family:var(--font-title); font-size:0.95rem; width:60px;">No</th>
                  <th style="padding:10px; font-family:var(--font-title); font-size:0.95rem;">Nama Kepala Desa / Lurah</th>
                  <th style="padding:10px; font-family:var(--font-title); font-size:0.95rem;">Masa Jabatan</th>
                </tr>
              </thead>
              <tbody>
                <tr style="border-bottom:1px solid rgba(18,32,27,0.06);">
                  <td style="padding:10px; font-weight:800;">1</td>
                  <td style="padding:10px; font-weight:700;">Toredjo</td>
                  <td style="padding:10px;">s.d. 1921</td>
                </tr>
                <tr style="border-bottom:1px solid rgba(18,32,27,0.06);">
                  <td style="padding:10px; font-weight:800;">2</td>
                  <td style="padding:10px; font-weight:700;">Partodirjo</td>
                  <td style="padding:10px;">1921 &ndash; 1961</td>
                </tr>
                <tr style="border-bottom:1px solid rgba(18,32,27,0.06);">
                  <td style="padding:10px; font-weight:800;">3</td>
                  <td style="padding:10px; font-weight:700;">Moh. Amin</td>
                  <td style="padding:10px;">1961 &ndash; 1990</td>
                </tr>
                <tr style="border-bottom:1px solid rgba(18,32,27,0.06);">
                  <td style="padding:10px; font-weight:800;">4</td>
                  <td style="padding:10px; font-weight:700;">Moh Suroto</td>
                  <td style="padding:10px;">1990 &ndash; 2006</td>
                </tr>
                <tr style="border-bottom:1px solid rgba(18,32,27,0.06);">
                  <td style="padding:10px; font-weight:800;">5</td>
                  <td style="padding:10px; font-weight:700;">Emy Hariono</td>
                  <td style="padding:10px;">2007 &ndash; 2020</td>
                </tr>
                <tr style="border-bottom:1px solid rgba(18,32,27,0.06); background:var(--jade-soft);">
                  <td style="padding:10px; font-weight:800; color:var(--jade-main);">6</td>
                  <td style="padding:10px; font-weight:800; color:var(--jade-main);">Juremi</td>
                  <td style="padding:10px; font-weight:800; color:var(--jade-main);">Sekarang (Periode 2025)</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Data Prodeskel Kemendagri 2025 -->
    <div class="glass-card-white">
      <div class="section-head" style="margin-bottom: 24px;">
        <span class="kicker">Data Resmi Kemendagri</span>
        <h2>Profil Demografi &amp; Potensi Desa 2025</h2>
        <p>Sumber Isian Prodeskel (Profil Desa &amp; Kelurahan) Ditjen Bina Pemdes Kemendagri per Januari 2025.</p>
      </div>

      <div class="profil-demografi-grid">
        <div style="background:var(--jade-soft); border:1px solid rgba(13,138,108,0.2); padding:20px; border-radius:20px; text-align:center;">
          <div style="font-family:var(--font-title); font-size:2.2rem; font-weight:800; color:var(--jade-main);">2.920</div>
          <div style="font-size:0.8rem; font-weight:700; color:var(--ink-main); margin-top:4px;">Total Jiwa Penduduk</div>
          <div style="font-size:0.72rem; color:#586b63; margin-top:2px;">1.450 Laki-laki | 1.470 Perempuan</div>
        </div>

        <div style="background:rgba(245,158,11,0.12); border:1px solid rgba(255,182,39,0.3); padding:20px; border-radius:20px; text-align:center;">
          <div style="font-family:var(--font-title); font-size:2.2rem; font-weight:800; color:var(--ink-main);">916</div>
          <div style="font-size:0.8rem; font-weight:700; color:var(--ink-main); margin-top:4px;">Kepala Keluarga (KK)</div>
          <div style="font-size:0.72rem; color:#586b63; margin-top:2px;">786 KK Laki-laki | 130 KK Perempuan</div>
        </div>

        <div style="background:rgba(91,79,224,0.1); border:1px solid rgba(91,79,224,0.2); padding:20px; border-radius:20px; text-align:center;">
          <div style="font-family:var(--font-title); font-size:2.2rem; font-weight:800; color:var(--jade-dark);">110 Ha</div>
          <div style="font-size:0.8rem; font-weight:700; color:var(--ink-main); margin-top:4px;">Lahan Padi Sawah</div>
          <div style="font-size:0.72rem; color:#586b63; margin-top:2px;">Nilai Produksi Rp 2,31 Miliar/Th</div>
        </div>
      </div>

      <!-- Detail Rincian Sektor -->
      <div class="misi-glass-grid" style="grid-template-columns:repeat(2, 1fr);">
        <div class="misi-glass-card">
          <div class="num">&bull;</div>
          <div class="txt">
            <strong>Pertanian &amp; Komoditas Unggulan:</strong><br>
            Padi Sawah 110 Ha (Produksi 6 Ton/Ha), Jagung 25 Ha (Rp 525 Juta), dan Kacang Tanah 25 Ha (Rp 160 Juta).
          </div>
        </div>

        <div class="misi-glass-card">
          <div class="num">&bull;</div>
          <div class="txt">
            <strong>Ketenagakerjaan:</strong><br>
            1.301 Angkatan Kerja, 730 Bekerja Penuh, 450 Bekerja Tidak Tentu, 350 Ibu Rumah Tangga, 90 Pelajar.
          </div>
        </div>

        <div class="misi-glass-card">
          <div class="num">&bull;</div>
          <div class="txt">
            <strong>Kesehatan &amp; Sanitasi:</strong><br>
            8 Unit Posyandu Aktif (38 Kader), 700 KK Pelanggan PAM Air Bersih, 0 Kematian Ibu Melahirkan.
          </div>
        </div>

        <div class="misi-glass-card">
          <div class="num">&bull;</div>
          <div class="txt">
            <strong>Keamanan &amp; Ketertiban:</strong><br>
            21 RT Pos Siskamling Aktif, 30 Anggota Hansip/Linmas, 100% Realisasi Pajak Bumi &amp; Bangunan (PBB).
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

