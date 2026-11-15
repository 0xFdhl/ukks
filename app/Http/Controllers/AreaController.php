<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.area.index', [
            'areaList' => AreaParkir::withCount('transaksis')->orderBy('nama_area')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.area.create', ['area' => new AreaParkir()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_area' => ['required', 'string', 'max:255', 'unique:tb_area_parkir,nama_area'],
            'kapasitas' => ['required', 'integer', 'min:1', 'max:1000000'],
        ]);

        $area = AreaParkir::create($data + ['terisi' => 0]);
        ActivityLogger::record("Menambahkan area {$area->nama_area} dengan kapasitas {$area->kapasitas}.");

        return redirect()->route('admin.area.index')->with('success', 'Area parkir berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AreaParkir $area): RedirectResponse
    {
        return redirect()->route('admin.area.edit', $area);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AreaParkir $area): View
    {
        return view('admin.area.edit', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AreaParkir $area): RedirectResponse
    {
        $data = $request->validate([
            'nama_area' => ['required', 'string', 'max:255', Rule::unique('tb_area_parkir', 'nama_area')->ignore($area->id)],
            'kapasitas' => ['required', 'integer', 'min:1', 'max:1000000'],
        ]);

        if ($data['kapasitas'] < $area->terisi) {
            return back()->withInput()->withErrors(['kapasitas' => 'Kapasitas tidak boleh lebih kecil dari jumlah kendaraan yang sedang terisi.']);
        }

        $area->update($data);
        ActivityLogger::record("Memperbarui data area {$area->nama_area}.");

        return redirect()->route('admin.area.index')->with('success', 'Area parkir berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AreaParkir $area): RedirectResponse
    {
        if ($area->terisi > 0 || $area->transaksis()->exists()) {
            return back()->with('error', 'Area yang sedang terisi atau sudah dipakai transaksi tidak dapat dihapus.');
        }

        $nama = $area->nama_area;
        $area->delete();
        ActivityLogger::record("Menghapus area {$nama}.");

        return redirect()->route('admin.area.index')->with('success', 'Area parkir berhasil dihapus.');
    }
}
