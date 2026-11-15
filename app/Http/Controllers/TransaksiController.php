<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TransaksiController extends Controller
{
    public function index(): View
    {
        $transaksiAktif = Transaksi::with(['kendaraan', 'tarif', 'area', 'user'])
            ->where('status', 'masuk')->latest('waktu_masuk')->get();
        $riwayat = Transaksi::with(['kendaraan', 'tarif', 'area', 'user'])
            ->where('status', 'keluar')->latest('waktu_keluar')->limit(20)->get();

        return view('petugas.transaksi.index', [
            'transaksiAktif' => $transaksiAktif,
            'riwayat' => $riwayat,
            'kendaraan' => Kendaraan::orderBy('plat_nomor')->get(),
            'area' => AreaParkir::orderBy('nama_area')->get(),
        ]);
    }

    public function masuk(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id_kendaraan' => ['required', 'integer', 'exists:tb_kendaraan,id'],
            'id_area' => ['required', 'integer', 'exists:tb_area_parkir,id'],
        ]);

        DB::transaction(function () use ($data, $request) {
            $kendaraan = Kendaraan::whereKey($data['id_kendaraan'])
                ->lockForUpdate()
                ->firstOrFail();
            $tarif = Tarif::where('jenis_kendaraan', $kendaraan->jenis_kendaraan)->first();
            if (!$tarif) {
                throw ValidationException::withMessages(['id_kendaraan' => 'Tarif untuk jenis kendaraan ini belum tersedia.']);
            }
            if (Transaksi::where('id_kendaraan', $kendaraan->id)->where('status', 'masuk')->exists()) {
                throw ValidationException::withMessages(['id_kendaraan' => 'Kendaraan ini masih tercatat berada di area parkir.']);
            }

            $area = AreaParkir::whereKey($data['id_area'])->lockForUpdate()->firstOrFail();
            if ($area->terisi >= $area->kapasitas) {
                throw ValidationException::withMessages(['id_area' => 'Area parkir sudah penuh. Silakan pilih area lain.']);
            }

            Transaksi::create([
                'id_kendaraan' => $kendaraan->id,
                'waktu_masuk' => Carbon::now(),
                'id_tarif' => $tarif->id,
                'status' => 'masuk',
                'id_user' => $request->user()->id,
                'id_area' => $area->id,
            ]);
            $area->increment('terisi');
            $this->catat($request, "Mencatat kendaraan {$kendaraan->plat_nomor} masuk ke {$area->nama_area}.");
        });

        return back()->with('success', 'Kendaraan berhasil dicatat masuk.');
    }

    public function keluar(Request $request, int $id): RedirectResponse
    {
        $selesai = DB::transaction(function () use ($request, $id) {
            $transaksi = Transaksi::with('kendaraan')->whereKey($id)->lockForUpdate()->firstOrFail();
            if ($transaksi->status !== 'masuk') {
                throw ValidationException::withMessages(['transaksi' => 'Transaksi ini sudah diproses keluar.']);
            }

            $waktuKeluar = Carbon::now();
            $waktuMasuk = Carbon::parse($transaksi->waktu_masuk);
            $durasi = max(1, (int) ceil($waktuMasuk->diffInSeconds($waktuKeluar) / 3600));
            $tarif = Tarif::findOrFail($transaksi->id_tarif);

            $transaksi->update([
                'waktu_keluar' => $waktuKeluar,
                'durasi_jam' => $durasi,
                'biaya_total' => $durasi * $tarif->tarif_per_jam,
                'status' => 'keluar',
            ]);

            $area = AreaParkir::whereKey($transaksi->id_area)->lockForUpdate()->firstOrFail();
            $area->update(['terisi' => max(0, $area->terisi - 1)]);
            $this->catat($request, "Memproses kendaraan {$transaksi->kendaraan->plat_nomor} keluar. Biaya Rp ".number_format($durasi * $tarif->tarif_per_jam, 0, ',', '.').'.');

            return $transaksi->id;
        });

        return redirect()->route('petugas.struk', $selesai)->with('success', 'Transaksi keluar selesai.');
    }

    public function struk(int $id): View
    {
        $transaksi = Transaksi::with(['kendaraan', 'tarif', 'area', 'user'])->findOrFail($id);

        return view('petugas.transaksi.struk', compact('transaksi'));
    }

    private function catat(Request $request, string $aktivitas): void
    {
        LogAktivitas::create([
            'id_user' => $request->user()->id,
            'aktivitas' => $aktivitas,
            'waktu_aktivitas' => Carbon::now(),
        ]);
    }
}
