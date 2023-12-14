<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $username = 'Admin' . Str::random(2) . '@gmail.com';

        $password = Str::random(16);
        $passwordHash = Hash::make($password);

        Log::channel('seeding')->info(
            'username:' . $username . "\n"
                . 'password:' . $password
        );

        return [
            'username' => $username,
            'password' => $passwordHash,
            'user_privilege' => 'Admin',
        ];
    }
}
