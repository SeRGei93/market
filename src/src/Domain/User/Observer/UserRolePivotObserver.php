<?php

namespace Domain\User\Observer;

use Carbon\Carbon;
use Domain\User\Model\UserRole;
use Domain\User\Model\UserRolePivot;

class UserRolePivotObserver
{
    public function created(UserRolePivot $model): void
    {
    }

    public function deleted(UserRolePivot $model): void
    {
    }

    public function forceDeleted(UserRolePivot $model): void
    {
    }
}
