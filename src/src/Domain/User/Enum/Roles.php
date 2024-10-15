<?php

declare(strict_types=1);

namespace Domain\User\Enum;

enum Roles: string
{
    case admin = 'admin';
    case client = 'client';
}
