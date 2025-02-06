<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\FamilyMemberDetail;

class FamilyMemberDetailSeeder extends Seeder
{
    public function run()
    {
        FamilyMemberDetail::factory(10)->create();
    }
}
