<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use App\Models\FamilyMemberDetail;
use App\Models\User; // Ensure this points to your Users model
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create a specific user with predefined attributes
        User::factory()->create([
            'block_number' => strtoupper(chr(rand(65, 90))) . '-' . rand(100, 999), // Example: A-123
            'first_name' => 'Test',
            'last_name' => 'User',
            'role' => 'admin',
            'mobile' => 1234567890, // Ensure this is a unique mobile number
            'block' => 'Block A',
            'profile_photo' => null,
            'status' => 'active',
        ]);
        // Seed Users table
        User::factory(10)->create()->each(function ($user) {
            // For each user, create family members and vehicles
            FamilyMemberDetail::factory(3)->create([
                'user_id' => $user->id // Associate each family member with the user
            ]);

            Vehicle::factory(2)->create([
                'user_id' => $user->id // Associate each vehicle with the user
            ]);
        });

        // Call the UsersSeeder to create additional users
        $this->call(UsersSeeder::class);
        $this->call(NoticeSeeder::class);
        $this->call([
            DesignationSeeder::class,  // Add this line
        ]);


        // Create roles
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'owner']);
        Role::create(['name' => 'tenant']);

        // Create permissions
        Permission::create(['name' => 'create post']);
        Permission::create(['name' => 'edit post']);
        Permission::create(['name' => 'delete post']);
        Permission::create(['name' => 'view post']);

        // Assign permissions to roles
        $superAdminRole = Role::findByName('super-admin');
        $adminRole = Role::findByName('admin');

        $superAdminRole->givePermissionTo(Permission::all()); // super-admin gets all permissions
        $adminRole->givePermissionTo('create post', 'edit post'); // admin gets limited permissions
    }
}
