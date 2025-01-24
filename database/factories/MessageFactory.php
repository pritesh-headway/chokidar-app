<?php
// database/factories/MessageFactory.php

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
        // // Pick a random sender
        // $sender = User::inRandomOrder()->first();

        // // Pick a random receiver, ensuring they are different from the sender
        // $receiver = User::inRandomOrder()->first();
        // while ($sender->id === $receiver->id) {
        //     $receiver = User::inRandomOrder()->first();
        // }

        // // Check if a conversation exists between this sender and receiver
        // $conversation = Conversation::where(function ($query) use ($sender, $receiver) {
        //     $query->where('sender_id', $sender->id)
        //         ->where('receiver_id', $receiver->id);
        // })->orWhere(function ($query) use ($sender, $receiver) {
        //     $query->where('sender_id', $receiver->id)
        //         ->where('receiver_id', $sender->id);
        // })->first();

        // // If no conversation exists, create a new one
        // if (!$conversation) {
        //     $conversation = Conversation::create([
        //         'sender_id' => $sender->id,
        //         'receiver_id' => $receiver->id,
        //         'status' => 'active', // default status
        //     ]);
        // }
        $conversation = Conversation::inRandomOrder()->first();

        $faker = Faker::create('en_US'); // Set the locale to English (US)

        return [
            'conversation_id' => $conversation->id,
            'sender_id' => $conversation->sender_id,
            'receiver_id' => $conversation->receiver_id,
            'message' => $faker->sentence(), // Generates a random English sentence
            'is_read' => $faker->boolean, // Random true/false value
        ];
    }
}
