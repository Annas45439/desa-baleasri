<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Letter;
use App\Mail\LetterStatusUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LetterController extends Controller
{
    /**
     * Display a listing of letters.
     */
    public function index()
    {
        $letters = Letter::orderBy('created_at', 'desc')->paginate(20);
        $stats = [
            'total' => Letter::count(),
            'baru' => Letter::where('status', Letter::STATUS_BARU)->count(),
            'diproses' => Letter::where('status', Letter::STATUS_DIPROSES)->count(),
            'siap' => Letter::where('status', Letter::STATUS_SIAP_DIAMBIL)->count(),
            'selesai' => Letter::where('status', Letter::STATUS_SELESAI)->count(),
        ];

        return view('admin.surat.index', compact('letters', 'stats'));
    }

    /**
     * Show the form for editing the specified letter.
     */
    public function edit(Letter $letter)
    {
        return view('admin.surat.edit', compact('letter'));
    }

    /**
     * Update the specified letter in storage.
     */
    public function update(Request $request, Letter $letter)
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|unique:letters,nomor_surat,' . $letter->id,
            'catatan_admin' => 'nullable|string',
            'surat_pdf' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // Handle PDF upload
        if ($request->hasFile('surat_pdf')) {
            // Delete old file if exists
            if ($letter->surat_pdf && Storage::exists($letter->surat_pdf)) {
                Storage::delete($letter->surat_pdf);
            }

            $validated['surat_pdf'] = $request->file('surat_pdf')->store('surat', 'public');
        }

        $letter->update($validated);

        return redirect()->route('admin.letters.edit', $letter)
            ->with('success', 'Data surat berhasil diperbarui.');
    }

    /**
     * Update letter status.
     */
    public function updateStatus(Request $request, Letter $letter)
    {
        $validated = $request->validate([
            'status' => 'required|in:Baru,Diproses,Siap Diambil,Selesai,Ditolak',
        ]);

        $oldStatus = $letter->status;
        $newStatus = $validated['status'];

        // Validate status transition
        if ($oldStatus === Letter::STATUS_SELESAI || $oldStatus === Letter::STATUS_DITOLAK) {
            return back()->with('error', 'Status sudah final, tidak bisa diubah.');
        }

        // Update status and set processor
        $letter->update([
            'status' => $newStatus,
            'diproses_oleh' => auth()->user()->id,
        ]);

        // Set completion date if finished
        if ($newStatus === Letter::STATUS_SELESAI) {
            $letter->update(['tanggal_selesai' => now()]);
        }

        // Send email notification to user if email is provided
        if (!empty($letter->email) && filter_var($letter->email, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($letter->email)->send(new LetterStatusUpdate($letter, $oldStatus, $newStatus));
            } catch (\Throwable $exception) {
                \Illuminate\Support\Facades\Log::warning('Notifikasi email update status surat gagal dikirim.', [
                    'letter_id' => $letter->id,
                    'error' => $exception->getMessage()
                ]);
            }
        }

        return back()->with('success', "Status surat berhasil diubah menjadi: {$newStatus}");
    }

    /**
     * Delete letter.
     */
    public function destroy(Letter $letter)
    {
        // Delete PDF if exists
        if ($letter->surat_pdf && Storage::exists($letter->surat_pdf)) {
            Storage::delete($letter->surat_pdf);
        }

        // Delete file dokumen if exists
        if ($letter->dokumen_pendukung && Storage::exists($letter->dokumen_pendukung)) {
            Storage::delete($letter->dokumen_pendukung);
        }

        $letter->delete();

        return back()->with('success', 'Pengajuan surat berhasil dihapus.');
    }

    /**
     * Show reports.
     */
    public function report(Request $request)
    {
        $period = $request->get('period', 'monthly'); // monthly, weekly, yearly
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $query = Letter::whereYear('created_at', $year);

        if ($period === 'monthly') {
            $query->whereMonth('created_at', $month);
        } elseif ($period === 'yearly') {
            // No additional filter
        }

        $letters = $query->get();

        // Statistics
        $stats = [
            'total' => $letters->count(),
            'by_jenis' => $letters->groupBy('jenis_surat')->map->count(),
            'by_status' => $letters->groupBy('status')->map->count(),
            'selesai' => $letters->where('status', Letter::STATUS_SELESAI)->count(),
        ];

        $complaintStats = [
            'total' => Complaint::count(),
            'baru' => Complaint::where('status', 'Baru')->count(),
            'diproses' => Complaint::where('status', 'Diproses')->count(),
            'selesai' => Complaint::where('status', 'Selesai')->count(),
        ];

        return view('admin.surat.report', compact('letters', 'stats', 'complaintStats', 'period', 'year', 'month'));
    }

    /**
     * Export report to Excel/CSV.
     */
    public function exportReport(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $query = Letter::whereYear('created_at', $year);

        if ($period === 'monthly') {
            $query->whereMonth('created_at', $month);
        }

        $letters = $query->orderBy('created_at', 'desc')->get();

        $complaintsQuery = Complaint::whereYear('created_at', $year);
        if ($period === 'monthly') {
            $complaintsQuery->whereMonth('created_at', $month);
        }
        $complaints = $complaintsQuery->orderBy('created_at', 'desc')->get();

        $filename = "Report-Surat-{$period}-{$year}-{$month}.csv";

        $csv = fopen('php://memory', 'r+');

        // Header
        fputcsv($csv, [
            'Tipe Data',
            'No. Referensi / Nama',
            'NIK / Kontak',
            'Email',
            'Jenis / Kategori',
            'Status',
            'Nomor Surat',
            'Tanggal Pengajuan',
            'Tanggal Selesai',
        ]);

        foreach ($letters as $letter) {
            fputcsv($csv, [
                'Surat',
                $letter->ref_number,
                $letter->nik,
                $letter->email,
                $letter->jenis_surat,
                $letter->status,
                $letter->nomor_surat ?? '-',
                $letter->tanggal_pengajuan?->format('d-m-Y H:i') ?? '-',
                $letter->tanggal_selesai?->format('d-m-Y H:i') ?? '-',
            ]);
        }

        foreach ($complaints as $complaint) {
            fputcsv($csv, [
                'Pengaduan',
                $complaint->nama,
                $complaint->kontak,
                '-',
                $complaint->kategori,
                $complaint->status,
                '-',
                $complaint->created_at?->format('d-m-Y H:i') ?? '-',
                '-',
            ]);
        }

        rewind($csv);
        $content = stream_get_contents($csv);
        fclose($csv);

        return response($content, 200)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', "attachment; filename=$filename");
    }
}
