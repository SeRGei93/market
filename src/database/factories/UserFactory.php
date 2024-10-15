<?php

namespace Database\Factories;

use Domain\User\Enum\Gender;
use Domain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(Gender::toArray());
        $email = fake()->unique()->safeEmail();
        return [
            'name' => fake()->firstName($gender),
            'surname' => fake()->lastName($gender),
            'email' => $email,
            'phone' => fake()->unique()->numerify('37529#######'),
            'email_verified_at' => $email ? now() : null,
            'phone_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
            'gender' => $gender,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
