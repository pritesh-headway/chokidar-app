<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Complaint;

class ComplaintSeeder extends Seeder
{
    public function run()
    {

        Complaint::factory()->count(10)->create();
    }
}
