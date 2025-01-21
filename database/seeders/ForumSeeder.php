<?php


namespace Database\Seeders;

use App\Models\Forum;
use App\Models\Response;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\Output\Default\ProgressPrinter\TestRunnerExecutionStartedSubscriber;

class ForumSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Forum::truncate();
        // Forum::factory(10)->create(); // Create 10 forum posts using the factory

        // Create some forums
        $forums = Forum::factory(10)->create(); // Creating 5 forums as an example

        // Create responses for each forum
        foreach ($forums as $forum) {
            // Create 4 responses for each forum
            Response::factory(4)->create([
                'forum_id' => $forum->id, // Assign the forum_id for each response
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
