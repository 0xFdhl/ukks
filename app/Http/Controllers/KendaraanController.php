<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $kendaraans = Kendaraan::with('user')
            ->when($request->filled('q'), fn ($query) => $query->where(
                fn ($search) => $search->where('plat_nomor', 'like', '%'.$request->q.'%')
                    ->orWhere('pemilik', 'like', '%'.$request->q.'%')
            ))
            ->orderBy('plat_nomor')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kendaraan.index', compact('kendaraans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.kendaraan.create', ['kendaraan' => new Kendaraan()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'plat_nomor' => ['required', 'string', 'max:15', 'unique:tb_kendaraan,plat_nomor'],
            'jenis_kendaraan' => ['required', Rule::in(['motor', 'mobil', 'lainnya'])],
            'warna' => ['nullable', 'string', 'max:30'],
            'pemilik' => ['nullable', 'string', 'max:255'],
        ]);
        $data['id_user'] = $request->user()->id;

        $kendaraan = Kendaraan::create($data);
        ActivityLogger::record("Mendaftarkan kendaraan {$kendaraan->plat_nomor}.");

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil didaftarkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kendaraan $kendaraan): RedirectResponse
    {
        return redirect()->route('admin.kendaraan.edit', $kendaraan);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kendaraan $kendaraan): View
    {
        return view('admin.kendaraan.edit', compact('kendaraan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kendaraan $kendaraan): RedirectResponse
    {
        $data = $request->validate([
            'plat_nomor' => ['required', 'string', 'max:15', Rule::unique('tb_kendaraan', 'plat_nomor')->ignore($kendaraan->id)],
            'jenis_kendaraan' => ['required', Rule::in(['motor', 'mobil', 'lainnya'])],
            'warna' => ['nullable', 'string', 'max:30'],
            'pemilik' => ['nullable', 'string', 'max:255'],
        ]);

        $kendaraan->update($data);
        ActivityLogger::record("Memperbarui data kendaraan {$kendaraan->plat_nomor}.");

        return redirect()->route('admin.kendaraan.index')->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kendaraan $kendaraan): RedirectResponse
    {
        if ($kendaraan->transaksis()->exists()) {
            return back()->with('error', 'Kendaraan yang pernah masuk transaksi tidak dapat dihapus.');
        }

        $platNomor = $kendaraan->plat_nomor;
        $kendaraan->delete();
        ActivityLogger::record("Menghapus kendaraan {$platNomor}.");

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
