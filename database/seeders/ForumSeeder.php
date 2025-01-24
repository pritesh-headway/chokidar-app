<?php

namespace Database\Seeders;

use App\Models\Forum;
use App\Models\Response;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForumSeeder extends Seeder
{
    public function run()
    {
        // Define how many forums you want to create
        $forumCount = 10;

        // Loop to create forum records
        Forum::factory($forumCount)->create()->each(function ($forum) {
            // For each forum created, we will now generate some responses
            $responsesCount = rand(1, 5); // Random number of responses (e.g., between 1 and 5)

            // Create responses for each forum (with random user_id from users table)
            Response::factory($responsesCount)->create([
                'forum_id' => $forum->id,
                'user_id' => \App\Models\User::inRandomOrder()->first()->id, // Random user_id for response
            ]);

            // After creating responses, update the forum's 'responses' count
            $forum->update([
                'responses' => $forum->responses()->count(), // Recalculate the number of responses
            ]);
        });

        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Forum::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
