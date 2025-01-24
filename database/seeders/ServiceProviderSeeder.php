<?php

namespace Database\Seeders;

use App\Models\ServiceProvider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceProvider::factory(10)->create();
        //     DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //     ServiceProvider::truncate();
        //     DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
