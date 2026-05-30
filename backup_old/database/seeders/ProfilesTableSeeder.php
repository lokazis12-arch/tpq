<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and create a profile for each based on their current role
        $users = DB::table('users')->get();
        
        foreach ($users as $user) {
            DB::table('profiles')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'role' => $user->role,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
