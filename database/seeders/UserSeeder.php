<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // 3 Regular Users
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'wallet_balance' => 1000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password123'),
                'wallet_balance' => 500.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'password' => Hash::make('password123'),
                'wallet_balance' => 300.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
