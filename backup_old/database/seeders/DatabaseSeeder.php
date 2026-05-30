<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Guru
        $guruId = DB::table('users')->insertGetId([
            'name' => 'Ustadz Hasan',
            'email' => 'guru@darulikhlas.com',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Wali Santri
        $waliId = DB::table('users')->insertGetId([
            'name' => 'Wali Murid',
            'email' => 'nama@email.com',
            'password' => Hash::make('password123'),
            'role' => 'wali_santri',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Santri
        $santriId = DB::table('santri')->insertGetId([
            'wali_santri_id' => $waliId,
            'nis' => '100123',
            'nama_lengkap' => 'Ahmad Rizky',
            'status_aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Progres Iqro Initial
        DB::table('progres_iqro')->insert([
            'santri_id' => $santriId,
            'guru_id' => $guruId,
            'tanggal' => now()->toDateString(),
            'level' => 'Iqro 3',
            'halaman' => '14',
            'status_lulus' => true,
            'catatan_guru' => 'Makharijul huruf tolong diperhatikan lagi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Profiles
        $this->call(ProfilesTableSeeder::class);
    }
}
