<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\House;
use Illuminate\Support\Facades\DB;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Set house_id to null for all users to avoid foreign key constraint issues
        // DB::table('users')->update(['house_id' => null]);

        // // Delete all houses instead of truncating the table
        // House::query()->delete();

        // // Optionally, reset the auto-increment counter
        // // DB::statement('ALTER TABLE houses AUTO_INCREMENT = 1');

        House::factory()->count(10)->create();
    }
}
