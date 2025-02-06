<?php

namespace Database\Seeders;

use App\Models\Security;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecuritySeeder extends Seeder
{
    public function run()
    {

        Security::factory(10)->create();
    }
}
