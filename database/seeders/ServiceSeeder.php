<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        Service::factory(10)->create(); // Adjust the number of records to be generated
        // Service::truncate();
    }
}
