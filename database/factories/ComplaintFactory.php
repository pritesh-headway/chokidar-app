<?php

namespace Database\Factories;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComplaintFactory extends Factory
{
    protected $model = Complaint::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first();
        return [
            'block_number' => $user->block_number,
            'complaint_by' => $user->first_name . ' ' . $user->last_name,
            'complaint_title' => $this->faker->sentence,
            'user_id' => $user->id,
            'complaint_desc' => $this->faker->paragraph,
            'date' => $this->faker->date,
            'complaint_status' => 'pending',
            'photos' => $this->faker->text,
            'status' => 'active',
        ];
    }
}
