<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogController extends Controller
{
    public function index(Request $request): View
    {
        $logs = LogAktivitas::with('user')
            ->when($request->filled('q'), fn ($query) => $query->where('aktivitas', 'like', '%'.$request->q.'%'))
            ->when($request->filled('tanggal'), fn ($query) => $query->whereDate('waktu_aktivitas', $request->tanggal))
            ->latest('waktu_aktivitas')
            ->paginate(20)
            ->withQueryString();

        return view('admin.log.index', compact('logs'));
    }
}
