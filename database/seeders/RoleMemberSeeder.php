<?php

namespace Database\Seeders;

use App\Models\RoleMember;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\RoleMember::factory(10)->create(); // Create 10 role members
        // RoleMember::truncate();
    }
}
