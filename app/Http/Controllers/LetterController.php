<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LetterController extends Controller
{
    /**
     * Show letter request page.
     */
    public function index()
    {
        $jenisSurat = Letter::getJenisSuratOptions();
        return view('public.surat.index', compact('jenisSurat'));
    }

    /**
     * Show status tracking page.
     */
    public function tracking()
    {
        return view('public.surat.tracking');
    }

    /**
     * Show letter status detail.
     */
    public function show(Letter $letter)
    {
        return view('public.surat.status', compact('letter'));
    }

    /**
     * Search letter by reference number or NIK.
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'search' => 'required|string|max:50',
        ]);

        $search = trim($validated['search']);
        $normalizedPhone = preg_replace('/\D+/', '', $search);

        $letter = Letter::query()
            ->where('nik', $search)
            ->orWhere('email', strtolower($search))
            ->orWhereRaw('REPLACE(REPLACE(REPLACE(REPLACE(no_telepon, " ", ""), "-", ""), "(", ""), ")", "") = ?', [$normalizedPhone])
            ->first();

        if (!$letter) {
            return redirect()->route('letters.tracking')
                ->with('error', 'Surat tidak ditemukan. Silakan periksa kembali NIK, email, atau nomor telepon Anda.');
        }

        return view('public.surat.status', compact('letter'));
    }

    /**
     * Store new letter request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:letters',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'jenis_surat' => 'required|in:' . implode(',', array_keys(Letter::getJenisSuratOptions())),
            'keperluan' => 'required|string|max:500',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('dokumen_pendukung')) {
            $validated['dokumen_pendukung'] = $request->file('dokumen_pendukung')->store('dokumen-surat', 'public');
        }

        // Set default status and timestamp
        $validated['status'] = Letter::STATUS_BARU;
        $validated['tanggal_pengajuan'] = now();

        // Create letter
        $letter = Letter::create($validated);

        $adminNumber = preg_replace('/[^0-9]/', '', (string) setting('whatsapp_admin'));
        if (str_starts_with($adminNumber, '0')) {
            $adminNumber = '62' . substr($adminNumber, 1);
        }
        $message = "Halo Admin Desa Baleasri, ada pengajuan surat baru.\n\n"
            . "Nomor referensi: {$letter->ref_number}\n"
            . "Nama: {$letter->nama_lengkap}\n"
            . "NIK: {$letter->nik}\n"
            . "Kontak: {$letter->no_telepon}\n"
            . "Email: {$letter->email}\n"
            . "Jenis surat: {$letter->jenis_surat}\n"
            . "Keperluan:\n{$letter->keperluan}";

        if ($letter->dokumen_pendukung) {
            $message .= "\n\nDokumen pendukung:\n" . url(Storage::url($letter->dokumen_pendukung));
        }

        if ($adminNumber) {
            return redirect()->away('https://wa.me/' . $adminNumber . '?text=' . urlencode($message));
        }

        return redirect()->route('letters.tracking')
            ->with('success', "Pengajuan surat berhasil! Nomor referensi: <strong>{$letter->ref_number}</strong>. Nomor WhatsApp admin belum dikonfigurasi.");
    }

    /**
     * Download surat PDF.
     */
    public function downloadPdf(Letter $letter)
    {
        // Check if PDF exists
        if (!$letter->surat_pdf || !Storage::exists($letter->surat_pdf)) {
            return back()->with('error', 'File surat tidak ditemukan.');
        }

        // Check if surat is ready for download
        if ($letter->status !== Letter::STATUS_SIAP_DIAMBIL && $letter->status !== Letter::STATUS_SELESAI) {
            return back()->with('error', 'Surat belum siap untuk diunduh. Status: ' . $letter->status);
        }

        return Storage::download($letter->surat_pdf, "Surat-{$letter->jenis_surat}-{$letter->ref_number}.pdf");
    }

    /**
     * Download dokumen pendukung.
     */
    public function downloadDokumen(Letter $letter)
    {
        // Check if dokumen exists
        if (!$letter->dokumen_pendukung || !Storage::exists($letter->dokumen_pendukung)) {
            return back()->with('error', 'File dokumen tidak ditemukan.');
        }

        return Storage::download($letter->dokumen_pendukung, "Dokumen-{$letter->ref_number}.pdf");
    }

    /**
     * Get letter status via API (for AJAX).
     */
    public function getStatus(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16',
        ]);

        $letter = Letter::where('nik', $validated['nik'])->first();

        if (!$letter) {
            return response()->json(['error' => 'Surat tidak ditemukan'], 404);
        }

        return response()->json([
            'ref_number' => $letter->ref_number,
            'status' => $letter->status,
            'jenis_surat' => $letter->jenis_surat,
            'tanggal_pengajuan' => $letter->tanggal_pengajuan->format('d-m-Y H:i'),
            'tanggal_selesai' => $letter->tanggal_selesai?->format('d-m-Y H:i'),
            'nomor_surat' => $letter->nomor_surat,
            'can_download' => $letter->status === Letter::STATUS_SIAP_DIAMBIL || $letter->status === Letter::STATUS_SELESAI,
        ]);
    }
}
