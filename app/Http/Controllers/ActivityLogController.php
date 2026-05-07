<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', ActivityLog::class);
        
        $logs = ActivityLog::with(['user'])
            ->when(request('user_id'), fn($q) => $q->where('user_id', request('user_id')))
            ->when(request('model_type'), fn($q) => $q->where('model_type', request('model_type')))
            ->when(request('action'), fn($q) => $q->where('action', request('action')))
            ->latest()
            ->paginate(50);

        $modelTypes = ActivityLog::distinct()->pluck('model_type')->sort();
        $actions = ActivityLog::distinct()->pluck('action')->sort();

        return view('admin.activity-logs.index', compact('logs', 'modelTypes', 'actions'));
    }

    public function show($id)
    {
        $log = ActivityLog::with(['user'])->findOrFail($id);
        $this->authorize('view', $log);
        
        return view('admin.activity-logs.show', compact('log'));
    }
}
