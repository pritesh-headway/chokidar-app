<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationFactory extends Factory
{
    protected $model = Conversation::class;

    public function definition()
    {

        $sender = User::inRandomOrder()->first();
        $receiver = User::inRandomOrder()->first();
        while ($sender->id === $receiver->id) {
            $receiver = User::inRandomOrder()->first();
        }

        return [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'status' => $this->faker->randomElement(['active', 'deactive']),
        ];
    }
}
