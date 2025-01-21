<?php

namespace Database\Factories;

use App\Models\Notice;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoticeFactory extends Factory
{
    protected $model = Notice::class;

    public function definition()
    {
        return [
            'notice_title' => $this->faker->sentence(),
            'notice_desc' => $this->faker->paragraph(),
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}