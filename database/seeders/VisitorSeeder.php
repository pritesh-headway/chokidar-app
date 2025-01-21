<?php

namespace Database\Seeders;

use App\Models\Visitor;
use Illuminate\Database\Seeder;

class VisitorSeeder extends Seeder
{
    public function run()
    {
        // Delete existing records from the visitors table before seeding
        // Visitor::truncate();

        // Create 5 visitors with random users
        Visitor::factory()->count(10)->create();
    }
}
