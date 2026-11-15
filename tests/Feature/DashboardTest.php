<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_renders(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Admin')
            ->assertSee('Transaksi Terbaru');
    }

    public function test_petugas_transaction_page_renders(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);

        $this->actingAs($petugas)
            ->get(route('petugas.transaksi.index'))
            ->assertOk()
            ->assertSee('Catat Kendaraan Masuk')
            ->assertSee('Kendaraan Sedang Parkir');
    }

    public function test_petugas_dashboard_renders(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);

        $this->actingAs($petugas)
            ->get(route('petugas.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Petugas');
    }

    public function test_owner_dashboard_and_date_range_report_render(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $petugas = User::factory()->create(['role' => 'petugas']);
        $tarif = Tarif::create(['jenis_kendaraan' => 'motor', 'tarif_per_jam' => 2000]);
        $area = AreaParkir::create(['nama_area' => 'Area Test', 'kapasitas' => 10, 'terisi' => 0]);
        $kendaraan = Kendaraan::create(['plat_nomor' => 'B9876XYZ', 'jenis_kendaraan' => 'motor']);
        Transaksi::create([
            'id_kendaraan' => $kendaraan->id,
            'waktu_masuk' => Carbon::parse('2026-11-15 08:00:00'),
            'waktu_keluar' => Carbon::parse('2026-11-15 09:00:00'),
            'id_tarif' => $tarif->id,
            'durasi_jam' => 1,
            'biaya_total' => 2000,
            'status' => 'keluar',
            'id_user' => $petugas->id,
            'id_area' => $area->id,
        ]);

        $this->actingAs($owner)
            ->get(route('owner.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Owner');

        $this->get(route('owner.rekap', [
            'tanggal_mulai' => '2026-11-15',
            'tanggal_selesai' => '2026-11-15',
        ]))
            ->assertOk()
            ->assertSee('B9876XYZ')
            ->assertSee('2.000');
    }
}
