<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::latest();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $stats = [
            'total' => Complaint::count(),
            'baru' => Complaint::where('status', 'Baru')->count(),
            'diproses' => Complaint::where('status', 'Diproses')->count(),
            'selesai' => Complaint::where('status', 'Selesai')->count(),
        ];

        $complaints = $query->paginate(12)->withQueryString();
        return view('admin.complaints.index', compact('complaints', 'stats'));
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $data = $request->validate(['status' => ['required', 'in:Baru,Diproses,Selesai']]);
        $complaint->update($data);

        log_activity('UPDATE_PENGADUAN', "Mengubah status pengaduan #{$complaint->ticket_code} milik {$complaint->nama} menjadi '{$complaint->status}'.");

        return back()->with('status', 'Status pengaduan berhasil diperbarui.');
    }
}
