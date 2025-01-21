<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Security;

class SecuritySeeder extends Seeder
{
    public function run()
    {
        // Create 10 fake securities
        Security::factory(10)->create();
    }
}
