<?php

namespace Phumsoft\Phumpie\Constants;

enum CTheme: string
{
    case AUTO = 'auto';
    case LIGHT = 'light';
    case DARK = 'dark';

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
