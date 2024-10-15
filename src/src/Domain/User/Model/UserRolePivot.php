<?php

declare(strict_types=1);

namespace Domain\User\Model;

use Domain\User\Observer\UserRolePivotObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[ObservedBy([UserRolePivotObserver::class])]
class UserRolePivot extends Pivot
{
}
