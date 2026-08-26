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

        $complaints = $query->paginate(12)->withQueryString();
        return view('admin.complaints.index', compact('complaints'));
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $data = $request->validate(['status' => ['required', 'in:Baru,Diproses,Selesai']]);
        $complaint->update($data);

        return back()->with('status', 'Status pengaduan berhasil diperbarui.');
    }
}
