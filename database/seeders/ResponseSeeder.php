<?php

// namespace Database\Seeders;

// use App\Models\Forum;
// use App\Models\Response;
// use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;

// class ResponseSeeder extends Seeder
// {
//     public function run()
//     {
//         // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

//         // Get all forums to randomly pick forum_id for responses
//         $forums = Forum::all();

//         // Loop through each forum and create responses
//         foreach ($forums as $forum) {
//             // Create 4 responses for each forum (or change the number as needed)
//             $responses = Response::factory(4)->create([
//                 'forum_id' => $forum->id, // Assign a random forum_id
//             ]);

//             // Update the response count in the forum table
//             $forum->update([
//                 'responses' => $forum->responses()->count(), // Update the responses count
//             ]);
//         }

//         // Response::truncate();
//         // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
//     }
// }

// database/seeders/ResponseSeeder.php
namespace Database\Seeders;

use App\Models\Response;
use Illuminate\Database\Seeder;

class ResponseSeeder extends Seeder
{
    public function run()
    {
        // Seed 10 random responses
        // Response::factory()->count(10)->create();
        Response::truncate();
    }
}
