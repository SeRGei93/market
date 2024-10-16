<?php

declare(strict_types=1);

namespace Support\Enum;

enum AttributeType: int
{
    case INT = 0;
    case STRING = 1;
    case FLOAT = 2;
    case DOUBLE = 3;
    case ENUM = 4;

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
