<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'nik',
        'no_telepon',
        'email',
        'jenis_surat',
        'keperluan',
        'dokumen_pendukung',
        'status',
        'nomor_surat',
        'catatan_admin',
        'surat_pdf',
        'tanggal_pengajuan',
        'tanggal_selesai',
        'diproses_oleh',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants
    const STATUS_BARU = 'Baru';
    const STATUS_DIPROSES = 'Diproses';
    const STATUS_SIAP_DIAMBIL = 'Siap Diambil';
    const STATUS_SELESAI = 'Selesai';
    const STATUS_DITOLAK = 'Ditolak';

    // Jenis Surat constants
    const JENIS_DOMISILI = 'Domisili';
    const JENIS_SKTM = 'SKTM';
    const JENIS_SKU = 'SKU';
    const JENIS_KEMATIAN = 'Kematian';
    const JENIS_KELAHIRAN = 'Kelahiran';
    const JENIS_PINDAH = 'Pindah';
    const JENIS_LAINNYA = 'Lainnya';

    /**
     * Get the user who processed this letter.
     */
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    /**
     * Scope: Get only new letters.
     */
    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_BARU);
    }

    /**
     * Scope: Get only processed letters.
     */
    public function scopeProcessed($query)
    {
        return $query->where('status', self::STATUS_DIPROSES);
    }

    /**
     * Scope: Get only ready letters.
     */
    public function scopeReady($query)
    {
        return $query->where('status', self::STATUS_SIAP_DIAMBIL);
    }

    /**
     * Scope: Get only finished letters.
     */
    public function scopeFinished($query)
    {
        return $query->where('status', self::STATUS_SELESAI);
    }

    /**
     * Generate reference number for letter.
     */
    public static function generateRefNumber()
    {
        return 'LSR-' . date('Y') . '-' . str_pad(self::max('id') + 1, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get reference number.
     */
    public function getRefNumberAttribute()
    {
        return 'LSR-' . $this->tanggal_pengajuan->year . '-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Check if letter can be processed.
     */
    public function canProcess()
    {
        return $this->status === self::STATUS_BARU;
    }

    /**
     * Check if letter can be marked as ready.
     */
    public function canMarkReady()
    {
        return $this->status === self::STATUS_DIPROSES && !empty($this->surat_pdf);
    }

    /**
     * Check if letter can be finished.
     */
    public function canFinish()
    {
        return $this->status === self::STATUS_SIAP_DIAMBIL;
    }

    /**
     * Get all available jenis surat options.
     */
    public static function getJenisSuratOptions()
    {
        return [
            self::JENIS_DOMISILI => 'Surat Keterangan Domisili',
            self::JENIS_SKTM => 'Surat Keterangan Tidak Mampu (SKTM)',
            self::JENIS_SKU => 'Surat Keterangan Usaha (SKU)',
            self::JENIS_KEMATIAN => 'Surat Keterangan Kematian',
            self::JENIS_KELAHIRAN => 'Surat Keterangan Kelahiran',
            self::JENIS_PINDAH => 'Surat Keterangan Pindah',
            self::JENIS_LAINNYA => 'Lainnya',
        ];
    }

    /**
     * Get all available status options.
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_BARU => 'Baru',
            self::STATUS_DIPROSES => 'Diproses',
            self::STATUS_SIAP_DIAMBIL => 'Siap Diambil',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DITOLAK => 'Ditolak',
        ];
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            self::STATUS_BARU => 'warning',
            self::STATUS_DIPROSES => 'info',
            self::STATUS_SIAP_DIAMBIL => 'success',
            self::STATUS_SELESAI => 'success',
            self::STATUS_DITOLAK => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get WhatsApp notification URL for applicant.
     */
    public function getWaNotifyUrlAttribute()
    {
        $phone = preg_replace('/[^0-9]/', '', (string) $this->no_telepon);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        if (empty($phone)) {
            return '#';
        }

        $msg = "Halo Bpk/Ibu *{$this->nama_lengkap}*,\n\n"
            . "Pemberitahuan dari Pemerintah Desa Baleasri mengenai pengajuan surat Anda:\n\n"
            . "• *No. Referensi*: {$this->ref_number}\n"
            . "• *Jenis Surat*: {$this->jenis_surat}\n"
            . "• *Status Pengajuan*: *{$this->status}*\n";

        if ($this->nomor_surat) {
            $msg .= "• *Nomor Surat*: {$this->nomor_surat}\n";
        }

        if ($this->catatan_admin) {
            $msg .= "• *Catatan Admin*: {$this->catatan_admin}\n";
        }

        if ($this->status === self::STATUS_DIPROSES) {
            $msg .= "\nPermohonan surat Anda sedang diproses oleh petugas kantor desa.";
        } elseif ($this->status === self::STATUS_SIAP_DIAMBIL) {
            $msg .= "\nSurat Anda *sudah selesai diproses dan siap diambil* di Kantor Desa Baleasri pada jam kerja.";
        } elseif ($this->status === self::STATUS_SELESAI) {
            $msg .= "\nSurat Anda *telah selesai diproses*.";
        } elseif ($this->status === self::STATUS_DITOLAK) {
            $msg .= "\nMohon maaf, permohonan surat Anda belum dapat diproses.";
        }

        if ($this->surat_pdf) {
            $msg .= "\n\n📄 *Download File Surat (PDF)*:\n" . url(\Illuminate\Support\Facades\Storage::url($this->surat_pdf));
        }

        $msg .= "\n\nCek status pengajuan surat Anda kapan saja melalui tautan berikut:\n"
            . url(route('letters.show', $this));

        $msg .= "\n\nTerima kasih.\n_Pemerintah Desa Baleasri_";

        return 'https://wa.me/' . $phone . '?text=' . urlencode($msg);
    }
}
