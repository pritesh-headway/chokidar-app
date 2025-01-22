<?php

// namespace Database\Factories;

// use App\Models\RoleMember;
// use App\Models\Role;
// use App\Models\User;
// use Illuminate\Database\Eloquent\Factories\Factory;

// class RoleMemberFactory extends Factory
// {
//     protected $model = RoleMember::class;

//     public function definition()
//     {
//         $user = User::inRandomOrder()->first();
//         $role = Role::inRandomOrder()->first();
//         return [
//             'role_id' => $role->id, // Random role ID from the roles table
//             'role_name' => $role->role_name, // Role name from roles table
//             'user_id' => $user->id, // Random user ID from users table
//             'profile_image' => $user->profile_photo,
//             'mobile' => $user->mobile,
//             'block_number' => $user->block_number,
//             'first_name' => $user->first_name,
//             'last_name' => $user->last_name,
//             'status' => $this->faker->randomElement(['active', 'deactive']),
//         ];
//     }
// }



namespace Database\Factories;

use App\Models\RoleMember;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleMemberFactory extends Factory
{
    protected $model = RoleMember::class;

    // To store the previously selected user IDs
    private static $selectedUsers = [];

    public function definition()
    {
        // Ensure unique selection of users and roles
        $user = User::whereNotIn('id', self::$selectedUsers)->inRandomOrder()->first();

        // If no users are left, you may decide how to handle it (optional)
        if (!$user) {
            // You could throw an exception, return a dummy user, or any other logic
            throw new \Exception('No more unique users available for selection.');
        }

        $role = Role::inRandomOrder()->first();

        // Add the selected user ID to the array of selected users
        self::$selectedUsers[] = $user->id;

        return [
            'role_id' => $role->id, // Use the selected role's ID
            'role_name' => $role->role_name, // Use the selected role's name
            'user_id' => $user->id, // Use the selected user's ID
            'profile_image' => $user->profile_photo, // Profile image from the selected user
            'mobile' => $user->mobile, // Mobile number from the selected user
            'block_number' => $user->block_number, // Block number from the selected user
            'first_name' => $user->first_name, // First name from the selected user
            'last_name' => $user->last_name, // Last name from the selected user
            'status' => $this->faker->randomElement(['active', 'deactive']), // Random status
        ];
    }
}
