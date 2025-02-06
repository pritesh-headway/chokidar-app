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

        $forumCount = 10;
        Forum::factory($forumCount)->create()->each(function ($forum) {

            $responsesCount = rand(1, 5);
            Response::factory($responsesCount)->create([
                'forum_id' => $forum->id,
                'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            ]);
            $forum->update([
                'responses' => $forum->responses()->count(),
            ]);
        });
    }
}
