<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
            ],
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]
        ];

        foreach ($data as $key => $value) {
            User::factory()->create($value);
        }

        User::factory(100)->create();
    }
}
