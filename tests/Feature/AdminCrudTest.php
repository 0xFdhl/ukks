<?php

namespace Tests\Feature;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_crud_pages_render(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        foreach ([
            'admin.user.index', 'admin.user.create',
            'admin.tarif.index', 'admin.tarif.create',
            'admin.area.index', 'admin.area.create',
            'admin.kendaraan.index', 'admin.kendaraan.create',
            'admin.log.index',
        ] as $route) {
            $this->get(route($route))->assertOk();
        }
    }

    public function test_only_admin_can_access_admin_routes_and_inactive_admin_is_blocked(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $this->actingAs($petugas)->get(route('admin.user.index'))->assertForbidden();

        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $this->get(route('admin.user.index'))->assertOk();
        $admin->update(['status_aktif' => false]);
        $this->get(route('admin.user.index'))->assertForbidden();
    }

    public function test_admin_can_create_user_rate_area_and_vehicle(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->post(route('admin.user.store'), [
            'nama_lengkap' => 'Petugas Baru',
            'username' => 'petugas-baru',
            'role' => 'petugas',
            'status_aktif' => 1,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('admin.user.index'));
        $this->assertDatabaseHas('users', ['username' => 'petugas-baru', 'role' => 'petugas']);

        $this->post(route('admin.tarif.store'), [
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 2500,
        ])->assertRedirect(route('admin.tarif.index'));
        $this->assertDatabaseHas('tb_tarif', ['jenis_kendaraan' => 'motor', 'tarif_per_jam' => 2500]);

        $this->post(route('admin.area.store'), [
            'nama_area' => 'Area Utara',
            'kapasitas' => 25,
        ])->assertRedirect(route('admin.area.index'));
        $this->assertDatabaseHas('tb_area_parkir', ['nama_area' => 'Area Utara', 'terisi' => 0]);

        $this->post(route('admin.kendaraan.store'), [
            'plat_nomor' => 'B1234ABC',
            'jenis_kendaraan' => 'motor',
            'warna' => 'Hitam',
            'pemilik' => 'Pemilik Baru',
        ])->assertRedirect(route('admin.kendaraan.index'));
        $this->assertDatabaseHas('tb_kendaraan', [
            'plat_nomor' => 'B1234ABC',
            'id_user' => $admin->id,
        ]);
    }

    public function test_admin_cannot_lower_area_capacity_below_current_occupancy(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $area = AreaParkir::create(['nama_area' => 'Area Penuh', 'kapasitas' => 5, 'terisi' => 4]);

        $this->actingAs($admin)
            ->from(route('admin.area.edit', $area))
            ->put(route('admin.area.update', $area), [
                'nama_area' => 'Area Penuh',
                'kapasitas' => 3,
            ])
            ->assertSessionHasErrors('kapasitas')
            ->assertRedirect(route('admin.area.edit', $area));

        $this->assertSame(5, $area->fresh()->kapasitas);
    }

    public function test_edit_forms_render_for_each_resource(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $tarif = Tarif::create(['jenis_kendaraan' => 'mobil', 'tarif_per_jam' => 5000]);
        $area = AreaParkir::create(['nama_area' => 'Area Selatan', 'kapasitas' => 12, 'terisi' => 0]);
        $kendaraan = Kendaraan::create(['plat_nomor' => 'D5555ABC', 'jenis_kendaraan' => 'mobil']);

        $this->actingAs($admin);
        $this->get(route('admin.user.edit', $user))->assertOk();
        $this->get(route('admin.tarif.edit', $tarif))->assertOk();
        $this->get(route('admin.area.edit', $area))->assertOk();
        $this->get(route('admin.kendaraan.edit', $kendaraan))->assertOk();
    }

    public function test_admin_can_update_and_delete_unused_resources(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $tarif = Tarif::create(['jenis_kendaraan' => 'motor', 'tarif_per_jam' => 2000]);
        $area = AreaParkir::create(['nama_area' => 'Area Lama', 'kapasitas' => 5, 'terisi' => 0]);
        $kendaraan = Kendaraan::create(['plat_nomor' => 'E1111ABC', 'jenis_kendaraan' => 'motor']);
        $this->actingAs($admin);

        $this->put(route('admin.user.update', $user), [
            'nama_lengkap' => 'Nama Diperbarui',
            'username' => $user->username,
            'role' => 'owner',
            'status_aktif' => 1,
            'password' => '',
            'password_confirmation' => '',
        ])->assertRedirect(route('admin.user.index'));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'nama_lengkap' => 'Nama Diperbarui', 'role' => 'owner']);
        $this->assertDatabaseHas('tb_log_aktivitas', ['aktivitas' => 'Memperbarui akun '.$user->username.'.']);

        $this->put(route('admin.tarif.update', $tarif), [
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 3000,
        ])->assertRedirect(route('admin.tarif.index'));
        $this->assertSame('3000', (string) $tarif->fresh()->tarif_per_jam);
        $this->assertDatabaseHas('tb_log_aktivitas', ['aktivitas' => 'Memperbarui tarif motor menjadi Rp 3.000.']);

        $this->put(route('admin.area.update', $area), [
            'nama_area' => 'Area Baru',
            'kapasitas' => 8,
        ])->assertRedirect(route('admin.area.index'));
        $this->assertDatabaseHas('tb_area_parkir', ['id' => $area->id, 'nama_area' => 'Area Baru']);
        $this->assertDatabaseHas('tb_log_aktivitas', ['aktivitas' => 'Memperbarui data area Area Baru.']);

        $this->put(route('admin.kendaraan.update', $kendaraan), [
            'plat_nomor' => 'E1111ABC',
            'jenis_kendaraan' => 'mobil',
            'warna' => 'Putih',
            'pemilik' => 'Pemilik Baru',
        ])->assertRedirect(route('admin.kendaraan.index'));
        $this->assertDatabaseHas('tb_kendaraan', ['id' => $kendaraan->id, 'jenis_kendaraan' => 'mobil']);
        $this->assertDatabaseHas('tb_log_aktivitas', ['aktivitas' => 'Memperbarui data kendaraan E1111ABC.']);
        $this->delete(route('admin.kendaraan.destroy', $kendaraan))
            ->assertRedirect(route('admin.kendaraan.index'))->assertSessionMissing('error');
        $this->assertDatabaseMissing('tb_kendaraan', ['id' => $kendaraan->id]);
        $this->assertDatabaseHas('tb_log_aktivitas', ['aktivitas' => 'Menghapus kendaraan E1111ABC.']);
        $this->delete(route('admin.area.destroy', $area))
            ->assertRedirect(route('admin.area.index'))->assertSessionMissing('error');
        $this->assertDatabaseMissing('tb_area_parkir', ['id' => $area->id]);
        $this->assertDatabaseHas('tb_log_aktivitas', ['aktivitas' => 'Menghapus area Area Baru.']);
        $this->delete(route('admin.tarif.destroy', $tarif))
            ->assertRedirect(route('admin.tarif.index'))->assertSessionMissing('error');
        $this->assertDatabaseMissing('tb_tarif', ['id' => $tarif->id]);
        $this->assertDatabaseHas('tb_log_aktivitas', ['aktivitas' => 'Menghapus tarif motor.']);
        $this->delete(route('admin.user.destroy', $user))
            ->assertRedirect(route('admin.user.index'))->assertSessionMissing('error');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseHas('tb_log_aktivitas', ['aktivitas' => 'Menghapus akun '.$user->username.'.']);
    }
}
