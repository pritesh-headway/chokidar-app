<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        Service::factory(9)->create(); // Adjust the number of records to be generated
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Service::truncate();
        // Service::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
