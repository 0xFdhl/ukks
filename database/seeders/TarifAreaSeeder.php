<?php

namespace Database\Seeders;

use App\Models\AreaParkir;
use App\Models\Tarif;
use Illuminate\Database\Seeder;

class TarifAreaSeeder extends Seeder
{
    /**
     * Create starter parking rates and areas.
     */
    public function run(): void
    {
        $tarif = [
            ['jenis_kendaraan' => 'motor', 'tarif_per_jam' => 2000],
            ['jenis_kendaraan' => 'mobil', 'tarif_per_jam' => 5000],
            ['jenis_kendaraan' => 'lainnya', 'tarif_per_jam' => 7000],
        ];

        foreach ($tarif as $item) {
            Tarif::updateOrCreate(
                ['jenis_kendaraan' => $item['jenis_kendaraan']],
                ['tarif_per_jam' => $item['tarif_per_jam']],
            );
        }

        $area = [
            ['nama_area' => 'Area Motor', 'kapasitas' => 50],
            ['nama_area' => 'Area Mobil', 'kapasitas' => 30],
            ['nama_area' => 'Area Umum', 'kapasitas' => 20],
        ];

        foreach ($area as $item) {
            AreaParkir::firstOrCreate(
                ['nama_area' => $item['nama_area']],
                ['kapasitas' => $item['kapasitas'], 'terisi' => 0],
            );
        }
    }
}
