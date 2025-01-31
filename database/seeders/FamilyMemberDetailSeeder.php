<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\FamilyMemberDetail;


class FamilyMemberDetailSeeder extends Seeder
{
    // public function run()
    // {
    //     FamilyMemberDetail::factory()->count(10)->create();
    // }

    // public function run()
    // {
    //     // Empty the family_member_details table first (preserving structure)
    //     FamilyMemberDetail::truncate();

    //     // Get all user ids from the users table
    //     $userIds = User::pluck('id')->toArray(); // This will give an array of all user ids

    //     // Create sample family member details and link them to existing users
    //     foreach ($userIds as $userId) {
    //         FamilyMemberDetail::create([
    //             'block_number' => 'A-101',
    //             'member_name' => 'Sample Name ' . $userId,
    //             'user_id' => $userId,  // Use existing user_id from the users table
    //             'mobile' => '9012345678',
    //             'status' => 'active',  // You can randomly set this or change based on your needs
    //         ]);
    //     }
    // }

    public function run()
    {
        // Empty the family_member_details table first (preserving structure)
        // FamilyMemberDetail::truncate();

        // // Get all user ids and their block_number from the users table
        // $users = User::all(); // This will get all users with their respective block numbers

        // // Loop through each user and add multiple family members for each
        // foreach ($users as $user) {
        //     // Create 3 family members for each user (you can adjust the count as needed)
        //     for ($i = 1; $i <= 3; $i++) {
        //         FamilyMemberDetail::create([
        //             'block_number' => $user->block_number, // Use the block_number of the user
        //             'member_name' => 'Family Member ' . $user->id . '-' . $i,
        //             'user_id' => $user->id,  // Use existing user_id from the users table
        //             'mobile' => '901234567' . $i,
        //             'status' => 'active',  // You can randomly set this or change based on your needs
        //         ]);
        //     }
        // }

        // FamilyMemberDetail::truncate();
        FamilyMemberDetail::factory(10)->create();
    }
}
