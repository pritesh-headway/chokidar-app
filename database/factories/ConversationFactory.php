<?php
// database/factories/ConversationFactory.php
// database/factories/ConversationFactory.php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationFactory extends Factory
{
    protected $model = Conversation::class;

    public function definition()
    {
        // Pick a random sender and receiver, ensuring they are different users
        $sender = User::inRandomOrder()->first();
        $receiver = User::inRandomOrder()->first();

        // Ensure sender and receiver are different
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
