<?php

declare(strict_types=1);

namespace Domain\User\Enum;

enum Gender: string
{
    case MALE = 'M';
    case FEMALE = 'F';
    case NOT_DEFINED = 'N';

    public static function toArray(): array
    {
        return array_column(Gender::cases(), 'value');
    }

    public function toString(): ?string
    {
        return $this->cyrillicValues()[$this->value];
    }

    private function cyrillicValues(): array
    {
        return [
            self::MALE->value => 'Мужской',
            self::FEMALE->value => 'Женский',
            self::NOT_DEFINED->value => 'Не определен',
        ];
    }

    public static function cast(string $value): ?self
    {
        return match ($value) {
            'Мужчина', 'Мужской', 'M' => self::MALE,
            'Женщина', 'Женский', 'F' => self::FEMALE,
            'Не Определен', 'НеОпределен' => self::NOT_DEFINED,
            default => null
        };
    }
}
