<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Create the initial accounts for each application role.
     */
    public function run(): void
    {
        $accounts = [
            [
                'nama_lengkap' => 'Administrator',
                'username' => 'admin',
                'role' => 'admin',
            ],
            [
                'nama_lengkap' => 'Petugas Parkir',
                'username' => 'petugas',
                'role' => 'petugas',
            ],
            [
                'nama_lengkap' => 'Pemilik Parkir',
                'username' => 'owner',
                'role' => 'owner',
            ],
        ];

        foreach ($accounts as $account) {
            User::updateOrCreate(
                ['username' => $account['username']],
                [
                    'nama_lengkap' => $account['nama_lengkap'],
                    'role' => $account['role'],
                    'status_aktif' => true,
                    'password' => 'password',
                ],
            );
        }
    }
}
