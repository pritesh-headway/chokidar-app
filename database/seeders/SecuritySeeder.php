<?php

namespace Database\Seeders;

use App\Models\Security;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecuritySeeder extends Seeder
{
    public function run()
    {
        // Create 10 fake securities
        Security::factory(10)->create();
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Security::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
