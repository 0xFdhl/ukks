<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'jumlahKendaraan' => Kendaraan::count(),
            'transaksiAktif' => Transaksi::where('status', 'masuk')->count(),
            'kapasitasArea' => AreaParkir::sum('kapasitas'),
            'areaTerisi' => AreaParkir::sum('terisi'),
            'pendapatanHariIni' => Transaksi::where('status', 'keluar')
                ->whereDate('waktu_keluar', Carbon::today())
                ->sum('biaya_total'),
            'transaksiTerbaru' => Transaksi::with(['kendaraan', 'area'])
                ->latest()
                ->limit(8)
                ->get(),
        ]);
    }
}
