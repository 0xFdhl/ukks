<?php

namespace Tests\Feature;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransaksiTest extends TestCase
{
    use RefreshDatabase;

    public function test_vehicle_entry_creates_transaction_and_updates_area_occupancy(): void
    {
        [$petugas, $kendaraan, $area] = $this->siapkanData();

        $response = $this->actingAs($petugas)->post(route('petugas.transaksi.masuk'), [
            'id_kendaraan' => $kendaraan->id,
            'id_area' => $area->id,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tb_transaksi', [
            'id_kendaraan' => $kendaraan->id,
            'id_area' => $area->id,
            'id_user' => $petugas->id,
            'status' => 'masuk',
        ]);
        $this->assertSame(1, $area->fresh()->terisi);
        $this->assertDatabaseCount('tb_log_aktivitas', 1);
    }

    public function test_vehicle_exit_rounds_duration_up_and_updates_area_occupancy(): void
    {
        [$petugas, $kendaraan, $area, $tarif] = $this->siapkanData();
        $transaksi = Transaksi::create([
            'id_kendaraan' => $kendaraan->id,
            'waktu_masuk' => Carbon::parse('2026-11-15 10:00:00'),
            'id_tarif' => $tarif->id,
            'status' => 'masuk',
            'id_user' => $petugas->id,
            'id_area' => $area->id,
        ]);
        $area->update(['terisi' => 1]);
        Carbon::setTestNow(Carbon::parse('2026-11-15 11:00:01'));

        try {
            $response = $this->actingAs($petugas)->post(route('petugas.transaksi.keluar', $transaksi->id));
            $response->assertRedirect(route('petugas.struk', $transaksi->id));
            $this->assertDatabaseHas('tb_transaksi', [
                'id' => $transaksi->id,
                'durasi_jam' => 2,
                'biaya_total' => 4000,
                'status' => 'keluar',
            ]);
            $this->assertSame(0, $area->fresh()->terisi);
            $this->assertDatabaseCount('tb_log_aktivitas', 1);
        } finally {
            Carbon::setTestNow();
        }
    }

    public function test_receipt_shows_the_rate_used_even_if_the_rate_was_changed_later(): void
    {
        [$petugas, $kendaraan, $area, $tarif] = $this->siapkanData();
        $transaksi = Transaksi::create([
            'id_kendaraan' => $kendaraan->id,
            'waktu_masuk' => Carbon::parse('2026-11-15 08:00:00'),
            'waktu_keluar' => Carbon::parse('2026-11-15 10:00:00'),
            'id_tarif' => $tarif->id,
            'durasi_jam' => 2,
            'biaya_total' => 4000,
            'status' => 'keluar',
            'id_user' => $petugas->id,
            'id_area' => $area->id,
        ]);
        $tarif->update(['tarif_per_jam' => 10000]);

        $this->actingAs($petugas)
            ->get(route('petugas.struk', $transaksi->id))
            ->assertOk()
            ->assertSee('Rp 2.000')
            ->assertDontSee('Rp 10.000');
    }

    public function test_vehicle_cannot_enter_a_full_area_or_be_entered_twice(): void
    {
        [$petugas, $kendaraan, $area] = $this->siapkanData();
        $area->update(['terisi' => 1]);

        $this->actingAs($petugas)
            ->from(route('petugas.transaksi.index'))
            ->post(route('petugas.transaksi.masuk'), [
                'id_kendaraan' => $kendaraan->id,
                'id_area' => $area->id,
            ])
            ->assertSessionHasErrors('id_area');

        $area->update(['terisi' => 0]);
        Transaksi::create([
            'id_kendaraan' => $kendaraan->id,
            'waktu_masuk' => now(),
            'id_tarif' => Tarif::firstOrFail()->id,
            'status' => 'masuk',
            'id_user' => $petugas->id,
            'id_area' => $area->id,
        ]);

        $this->post(route('petugas.transaksi.masuk'), [
            'id_kendaraan' => $kendaraan->id,
            'id_area' => $area->id,
        ])->assertSessionHasErrors('id_kendaraan');
    }

    private function siapkanData(): array
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $tarif = Tarif::create(['jenis_kendaraan' => 'motor', 'tarif_per_jam' => 2000]);
        $area = AreaParkir::create(['nama_area' => 'Area Motor', 'kapasitas' => 1, 'terisi' => 0]);
        $kendaraan = Kendaraan::create([
            'plat_nomor' => 'B1234XYZ',
            'jenis_kendaraan' => 'motor',
            'pemilik' => 'Pemilik Test',
        ]);

        return [$petugas, $kendaraan, $area, $tarif];
    }
}
