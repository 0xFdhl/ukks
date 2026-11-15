<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_creates_initial_accounts_rates_and_areas(): void
    {
        $this->seed();
        $this->seed();

        $this->assertDatabaseHas('users', ['username' => 'admin', 'role' => 'admin', 'status_aktif' => 1]);
        $this->assertDatabaseHas('users', ['username' => 'petugas', 'role' => 'petugas', 'status_aktif' => 1]);
        $this->assertDatabaseHas('users', ['username' => 'owner', 'role' => 'owner', 'status_aktif' => 1]);
        $this->assertDatabaseHas('tb_tarif', ['jenis_kendaraan' => 'motor', 'tarif_per_jam' => 2000]);
        $this->assertDatabaseHas('tb_tarif', ['jenis_kendaraan' => 'mobil', 'tarif_per_jam' => 5000]);
        $this->assertDatabaseHas('tb_tarif', ['jenis_kendaraan' => 'lainnya', 'tarif_per_jam' => 7000]);
        $this->assertDatabaseHas('tb_area_parkir', ['nama_area' => 'Area Motor', 'kapasitas' => 50]);
        $this->assertDatabaseCount('users', 3);
        $this->assertDatabaseCount('tb_tarif', 3);
        $this->assertDatabaseCount('tb_area_parkir', 3);
    }
}
