<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display listing of admin audit activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($search = trim($request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'LIKE', "%{$search}%")
                  ->orWhere('user_name', 'LIKE', "%{$search}%")
                  ->orWhere('action', 'LIKE', "%{$search}%")
                  ->orWhere('ip_address', 'LIKE', "%{$search}%");
            });
        }

        if ($actionFilter = $request->input('action')) {
            $query->where('action', $actionFilter);
        }

        $logs = $query->paginate(20)->withQueryString();

        $actionTypes = ActivityLog::select('action')->distinct()->pluck('action');

        return view('admin.activity-logs.index', compact('logs', 'actionTypes', 'search', 'actionFilter'));
    }
}
