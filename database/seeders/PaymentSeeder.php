<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        DB::table('payments')->insert([
            [
                'society_id' => 2,
                'amount' => 1500,
                'transaction_id' => 'TXN11111',
                'status' => 'success',
                'payment_date' => '2024-02-01 09:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'society_id' => 3,
                'amount' => 2000,
                'transaction_id' => 'TXN22222',
                'status' => 'success',
                'payment_date' => '2024-02-01 11:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'society_id' => 5,
                'amount' => 2500,
                'transaction_id' => 'TXN12345',
                'status' => 'success',
                'payment_date' => '2024-02-01 10:15:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'society_id' => 5,
                'amount' => 3000,
                'transaction_id' => 'TXN33333',
                'status' => 'pending',
                'payment_date' => '2024-02-01 13:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
