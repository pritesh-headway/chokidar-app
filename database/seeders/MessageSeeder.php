<?php
// database/seeders/MessageSeeder.php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run()
    {
        Message::factory(20)->create();  // Create 20 sample messages
        // Message::truncate();
    }
}
