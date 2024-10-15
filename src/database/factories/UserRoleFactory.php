<?php

namespace Database\Factories;

use Domain\User\Model\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserRole>
 */
class UserRoleFactory extends Factory
{
    protected $model = UserRole::class;

    public function definition(): array
    {
        $name = 'test_role_' . $this->faker->unique()->randomNumber();
        return [
            'name' => $name,
            'slug' => $name,
        ];
    }
}
