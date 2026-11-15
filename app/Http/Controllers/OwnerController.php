<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OwnerController extends Controller
{
    public function dashboard(): View
    {
        $hariIni = Carbon::today();
        $bulanIni = Carbon::now()->startOfMonth();

        return view('owner.dashboard', [
            'pendapatanHariIni' => Transaksi::where('status', 'keluar')
                ->whereDate('waktu_keluar', $hariIni)
                ->sum('biaya_total'),
            'transaksiHariIni' => Transaksi::where('status', 'keluar')
                ->whereDate('waktu_keluar', $hariIni)
                ->count(),
            'pendapatanBulanIni' => Transaksi::where('status', 'keluar')
                ->whereDate('waktu_keluar', '>=', $bulanIni)
                ->whereDate('waktu_keluar', '<=', Carbon::today())
                ->sum('biaya_total'),
            'transaksiTerbaru' => Transaksi::with(['kendaraan', 'area', 'user'])
                ->where('status', 'keluar')
                ->latest('waktu_keluar')
                ->limit(10)
                ->get(),
        ]);
    }

    public function rekap(Request $request): View
    {
        $data = $request->validate([
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ]);
        $tanggalMulai = $data['tanggal_mulai'] ?? Carbon::today()->toDateString();
        $tanggalSelesai = $data['tanggal_selesai'] ?? $tanggalMulai;

        $query = Transaksi::with(['kendaraan', 'area', 'tarif', 'user'])
            ->where('status', 'keluar')
            ->whereDate('waktu_keluar', '>=', $tanggalMulai)
            ->whereDate('waktu_keluar', '<=', $tanggalSelesai);

        return view('owner.rekap', [
            'transaksis' => (clone $query)->latest('waktu_keluar')->paginate(20)->withQueryString(),
            'jumlahTransaksi' => (clone $query)->count(),
            'totalPendapatan' => (clone $query)->sum('biaya_total'),
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
        ]);
    }
}
