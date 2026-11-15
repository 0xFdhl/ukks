<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.tarif.index', [
            'tarifList' => Tarif::withCount('transaksis')->orderBy('jenis_kendaraan')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.tarif.create', ['tarif' => new Tarif()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'jenis_kendaraan' => ['required', Rule::in(['motor', 'mobil', 'lainnya']), 'unique:tb_tarif,jenis_kendaraan'],
            'tarif_per_jam' => ['required', 'numeric', 'min:0', 'max:9999999999'],
        ]);

        $tarif = Tarif::create($data);
        ActivityLogger::record("Menambahkan tarif {$tarif->jenis_kendaraan} sebesar Rp ".number_format($tarif->tarif_per_jam, 0, ',', '.').'.');

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarif $tarif): RedirectResponse
    {
        return redirect()->route('admin.tarif.edit', $tarif);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarif $tarif): View
    {
        return view('admin.tarif.edit', compact('tarif'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarif $tarif): RedirectResponse
    {
        $data = $request->validate([
            'jenis_kendaraan' => ['required', Rule::in(['motor', 'mobil', 'lainnya']), Rule::unique('tb_tarif', 'jenis_kendaraan')->ignore($tarif->id)],
            'tarif_per_jam' => ['required', 'numeric', 'min:0', 'max:9999999999'],
        ]);

        $tarif->update($data);
        ActivityLogger::record("Memperbarui tarif {$tarif->jenis_kendaraan} menjadi Rp ".number_format($tarif->tarif_per_jam, 0, ',', '.').'.');

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarif $tarif): RedirectResponse
    {
        if ($tarif->transaksis()->exists()) {
            return back()->with('error', 'Tarif sudah digunakan transaksi sehingga tidak dapat dihapus.');
        }

        $jenis = $tarif->jenis_kendaraan;
        $tarif->delete();
        ActivityLogger::record("Menghapus tarif {$jenis}.");

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil dihapus.');
    }
}
