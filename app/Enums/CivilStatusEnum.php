<?php

namespace App\Enums;

enum CivilStatusEnum: string
{
    case SINGLE = 'single';
    case MARRIED = 'married';
    case WIDOWED = 'widowed';
    case SEPARATED = 'separated';
    case DIVORCED = 'divorced';

    public function label(): string
    {
        return match ($this) {
            self::SINGLE => 'Single',
            self::MARRIED => 'Married',
            self::WIDOWED => 'Widowed',
            self::SEPARATED => 'Separated',
            self::DIVORCED => 'Divorced',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn ($status) => [
                'value' => $status->value,
                'label' => $status->label(),
            ],
            self::cases()
        );
    }
}
