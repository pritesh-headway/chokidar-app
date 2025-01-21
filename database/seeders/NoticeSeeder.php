<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notice;

class NoticeSeeder extends Seeder
{
    public function run()
    {
        // Create 10 fake notices
        \App\Models\Notice::factory(10)->create();
    }
}