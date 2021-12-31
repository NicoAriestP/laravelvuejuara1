<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'email' => 'admin@email.com',
            'password' => Hash::make('12345'),
            'api_token' => sha1(time()),
            'role_id' => 1,
        ]);
    }
}
