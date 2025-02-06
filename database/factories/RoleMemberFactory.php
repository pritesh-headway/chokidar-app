<?php

namespace Database\Factories;

use App\Models\RoleMember;
use App\Models\Designation;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleMemberFactory extends Factory
{
    protected $model = RoleMember::class;
    private static $selectedUsers = [];

    public function definition()
    {

        $user = User::whereNotIn('id', self::$selectedUsers)->inRandomOrder()->first();
        if (!$user) {

            throw new \Exception('No more unique users available for selection.');
        }

        $role = Designation::inRandomOrder()->first();
        self::$selectedUsers[] = $user->id;

        return [
            'role_id' => $role->id,
            'role_name' => $role->role_name,
            'user_id' => $user->id,
            'profile_image' => $user->profile_photo,
            'mobile' => $user->mobile,
            'block_number' => $user->block_number,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
