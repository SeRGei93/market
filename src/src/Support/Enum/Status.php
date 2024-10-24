<?php

declare(strict_types=1);

namespace Support\Enum;

enum Status: string
{
    case enable = '2';
    case disable = '1';
    case draft = '0';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
