<?php

namespace Phumsoft\Phumpie\Constants;

enum CLang: string
{
    case KH = 'kh';
    case EN = 'en';

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
