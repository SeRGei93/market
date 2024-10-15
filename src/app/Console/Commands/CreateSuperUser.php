<?php

namespace App\Console\Commands;

use Domain\User\Enum\Roles;
use Domain\User\Model\User;
use Domain\User\Model\UserRole;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use MoonShine\MoonShineAuth;
use Symfony\Component\Console\Attribute\AsCommand;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

#[AsCommand(name: 'market:user')]
class CreateSuperUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'market:user {--u|username=} {--N|name=} {--p|password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create super user';

    public function handle(): int
    {
        $username = $this->uniqueUsername();
        $name = $this->option('name') ?? text('Name', default: $username);
        $password = $this->option('password') ?? password('Password');

        if ($username && $name && $password) {
            /** @var User $user */
            $user = MoonShineAuth::model()->query()->create([
                config('moonshine.auth.fields.username', 'email') => $username,
                config('moonshine.auth.fields.name', 'name') => $name,
                config(
                    'moonshine.auth.fields.password',
                    'password'
                ) => Hash::make($password),
            ]);

            /** @var UserRole $role */
            $role = UserRole::where('slug', Roles::admin->value)->first();
            $user->roles()->attach($role->id);
            event(new Registered($user));

            info('User is created');
        } else {
            error('All params is required');
        }

        return self::SUCCESS;
    }

    private function uniqueUsername(): string
    {
        $username = $this->option('username');

        while (true) {
            $username ??= text(
                'Username(' . config(
                    'moonshine.auth.fields.username',
                    'email'
                ) . ')',
                required: true
            );

            $exists = MoonShineAuth::model()
                ->query()
                ->where(
                    config('moonshine.auth.fields.username', 'email'),
                    $username,
                )
                ->exists();

            if (!$exists) {
                break;
            }

            $this->components->warn('There is already a username, try another one');
            $username = null;
        }

        return $username;
    }
}
