<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Domain\User\Enum\Roles;
use Domain\User\Enum\Gender;
use Domain\User\Model\User;
use Domain\User\Model\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $clientRole = UserRole::query()->where('slug', Roles::client->value)->first();
        $adminRole = UserRole::query()->where('slug', Roles::admin->value)->first();

        // создаем пользователя админа
        User::factory(1)
            ->create([
                'email' => 'admin@404team.by',
                'password' => Hash::make('12345678'),
                'name' => 'Admin',
                'surname' => 'Administrator',
                'gender' => Gender::MALE->value,
            ])
            ->each(function (User $user) use ($adminRole) {
                $user->roles()->attach($adminRole->id);
            });

        User::factory(10)
            ->create()
            ->each(function (User $user) use ($clientRole) {
                $user->roles()->attach($clientRole->id);
            });
    }
}
