<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\View\View;

class PetugasController extends Controller
{
    public function dashboard(): View
    {
        return view('petugas.dashboard', [
            'transaksiAktif' => Transaksi::where('status', 'masuk')->count(),
            'transaksiHariIni' => Transaksi::whereDate('waktu_masuk', Carbon::today())->count(),
            'pendapatanHariIni' => Transaksi::where('status', 'keluar')
                ->whereDate('waktu_keluar', Carbon::today())
                ->sum('biaya_total'),
            'transaksiTerbaru' => Transaksi::with(['kendaraan', 'area'])
                ->latest('waktu_masuk')
                ->limit(5)
                ->get(),
        ]);
    }
}
