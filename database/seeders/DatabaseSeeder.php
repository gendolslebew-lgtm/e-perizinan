<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Santri;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. BUAT AKUN USER UNTUK MASING-MASING ROLE
        
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@pesantren.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $ustadz = User::create([
            'name' => 'Ustadz Ahmad',
            'email' => 'ustadz@pesantren.com',
            'password' => Hash::make('password'),
            'role' => 'ustadz',
        ]);

        $kamtib = User::create([
            'name' => 'Kamtib',
            'email' => 'kamtib@pesantren.com',
            'password' => Hash::make('password'),
            'role' => 'kamtib',
        ]);

        $wali = User::create([
            'name' => 'Wali Santri',
            'email' => 'wali@pesantren.com',
            'password' => Hash::make('password'),
            'role' => 'wali',
        ]);

        // 2. BUAT DATA SANTRI YANG TERHUBUNG KE AKUN WALI DI ATAS
        
       Santri::create([
            'user_id' => $wali->id,
            'nis' => '12345678',
            'nama_santri' => 'Abdillahil Kahfi',
            'kelas' => '10-A',
            'kamar' => 'Kamar Al-Ikhlas 03',
            'jenis_kelamin' => 'L', // <-- Diubah jadi L
        ]);

        Santri::create([
            'user_id' => $wali->id,
            'nis' => '87654321',
            'nama_santri' => 'Sonia MyWife',
            'kelas' => '08-B',
            'kamar' => 'Kamar Khadijah 01',
            'jenis_kelamin' => 'P', // <-- Diubah jadi P
        ]);
    }
}