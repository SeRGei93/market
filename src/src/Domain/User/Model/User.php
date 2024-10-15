<?php

declare(strict_types=1);

namespace Domain\User\Model;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Domain\User\Enum\Gender;
use Domain\User\Enum\Roles;
use Domain\User\Observer\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $email
 * @property string $uuid
 * @property int $phone
 * @property \DateTime $phone_verified_at
 * @property \DateTime $email_verified_at
 * @property \DateTime $last_login_at
 * @property \DateTime $otp_required_at
 * @property \DateTime $two_factor_confirmed_at
 * @property \DateTime $birthday
 * @property bool $is_active
 * @property int $old_site_id
 * @property string $old_password
 * @property Gender $gender
 * @property bool $deduplication_required
 * @method static User|Builder query()
 */
#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'active',
        'name',
        'surname',
        'email',
        'phone',
        'gender',
        'birthday',
        'password',
        'phone_verified_at',
        'email_verified_at',
        'sort',
        'avatar',
    ];

    protected $casts = [
        'active' => 'boolean',
        'phone' => 'int',
        'sort' => 'int',
        'birthday' => 'datetime',
        'gender' => Gender::class,
        'phone_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(UserRole::class)->using(UserRolePivot::class);
    }

    public function isSuperUser(): bool
    {
        /** @var UserRole $moonshineUserRole */
        foreach ($this->roles()->get() as $moonshineUserRole) {
            if ($moonshineUserRole->slug === Roles::admin->value) {
                return true;
            }
        }
        return false;
    }

    protected static function newFactory(): Factory|UserFactory
    {
        return UserFactory::new();
    }

    public function setLastLogin(): void
    {
        $this->last_login_at = Carbon::now()->toDateTimeString();
        $this->save();
    }
}
