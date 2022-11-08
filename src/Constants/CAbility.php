<?php

namespace Phumsoft\Phumpie\Constants;

enum CAbility: string
{
    case READ = 'read';
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';

    public static function values()
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
