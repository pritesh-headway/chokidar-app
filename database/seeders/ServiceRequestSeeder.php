<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceRequest;

class ServiceRequestSeeder extends Seeder
{
    public function run()
    {
        ServiceRequest::factory()->count(20)->create();
    }
}
