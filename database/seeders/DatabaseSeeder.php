<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use App\Models\FamilyMemberDetail;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        User::factory()->create([
            'block_number' => strtoupper(chr(rand(65, 90))) . '-' . rand(100, 999),
            'first_name' => 'Test',
            'last_name' => 'User',
            'role' => 'admin',
            'mobile' => 1234567890,
            'block' => 'Block A',
            'profile_photo' => null,
            'status' => 'active',
        ]);

        User::factory(10)->create()->each(function ($user) {

            FamilyMemberDetail::factory(3)->create([
                'user_id' => $user->id
            ]);

            Vehicle::factory(2)->create([
                'user_id' => $user->id
            ]);
        });
        $this->call(UsersSeeder::class);
        $this->call(NoticeSeeder::class);
        $this->call([
            DesignationSeeder::class,
        ]);
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'owner']);
        Role::create(['name' => 'tenant']);
        Permission::create(['name' => 'create post']);
        Permission::create(['name' => 'edit post']);
        Permission::create(['name' => 'delete post']);
        Permission::create(['name' => 'view post']);
        $superAdminRole = Role::findByName('super-admin');
        $adminRole = Role::findByName('admin');

        $superAdminRole->givePermissionTo(Permission::all());
        $adminRole->givePermissionTo('create post', 'edit post');
    }
}
