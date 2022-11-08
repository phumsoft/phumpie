<?php

namespace Phumsoft\Phumpie\Constants;

enum CLibrary: string
{
    case USER = 'user';
    case COMPANY = 'company';

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
