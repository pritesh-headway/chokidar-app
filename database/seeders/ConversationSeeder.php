<?php
// database/seeders/ConversationSeeder.php

namespace Database\Seeders;

use App\Models\Conversation;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    public function run()
    {
        Conversation::factory(10)->create();  // Create 10 sample conversations
    }
}
