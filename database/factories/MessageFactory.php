<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

use Faker\Factory as Faker;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition()
    {
        $conversation = Conversation::inRandomOrder()->first();

        $faker = Faker::create('en_US');

        return [
            'conversation_id' => $conversation->id,
            'sender_id' => $conversation->sender_id,
            'receiver_id' => $conversation->receiver_id,
            'message' => $faker->sentence(),
            'is_read' => $faker->boolean,
        ];
    }
}
