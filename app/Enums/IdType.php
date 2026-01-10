<?php

namespace App\Enums;

enum IdType: string
{
    case PASSPORT = 'passport';
    case DRIVERS_LICENSE = 'drivers_license';
    case NATIONAL_ID = 'national_id';
    case SSS = 'sss';
    case PHILHEALTH = 'philhealth';
    case TIN = 'tin';
    case VOTERS_ID = 'voters_id';

    public function label(): string
    {
        return match ($this) {
            self::PASSPORT => 'Passport',
            self::DRIVERS_LICENSE => 'Driver’s License',
            self::NATIONAL_ID => 'National ID',
            self::SSS => 'SSS',
            self::PHILHEALTH => 'PhilHealth',
            self::TIN => 'TIN',
            self::VOTERS_ID => 'Voter’s ID',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn ($type) => [
                'value' => $type->value,
                'label' => $type->label(),
            ],
            self::cases()
        );
    }
}
