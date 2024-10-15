<?php

namespace Domain\User\Observer;

use Domain\User\Model\User;
use Domain\User\Model\UserRole;
use Illuminate\Support\Carbon;

class UserRoleObserver
{
    public function updated(UserRole $userRole): void
    {
    }

    /**
     * Handle the UserRole "deleted" event.
     */
    public function deleted(UserRole $userRole): void
    {
    }

    /**
     * Handle the UserRole "force deleted" event.
     */
    public function forceDeleted(UserRole $userRole): void
    {
    }
}
