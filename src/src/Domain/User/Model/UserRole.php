<?php

declare(strict_types=1);

namespace Domain\User\Model;

use Database\Factories\UserRoleFactory;
use Domain\User\Observer\UserRoleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property boolean $otp
 */
#[ObservedBy([UserRoleObserver::class])]
class UserRole extends Model
{
    use HasFactory;

    protected $table = 'user_roles';

    protected $fillable = ['name', 'slug', 'otp'];

    protected $casts = [
        'id' => 'int',
        'otp' => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(UserRolePivot::class);
    }

    protected static function newFactory(): Factory|UserRoleFactory
    {
        return UserRoleFactory::new();
    }
}
