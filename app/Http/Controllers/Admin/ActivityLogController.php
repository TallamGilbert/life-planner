<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(50);

        $actions = ActivityLog::distinct()->pluck('action');
        
        return view('admin.activity-logs', compact('logs', 'actions'));
    }

    public function show(ActivityLog $log)
    {
        $log->load('user');
        return view('admin.activity-log-detail', compact('log'));
    }

    public function destroy(ActivityLog $log)
    {
        $log->delete();
        return back()->with('success', 'Activity log deleted!');
    }

    public function clear(Request $request)
    {
        $days = $request->days ?? 30;
        
        ActivityLog::where('created_at', '<', now()->subDays($days))->delete();
        
        return back()->with('success', "Logs older than {$days} days have been deleted!");
    }
}