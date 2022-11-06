<?php

use Illuminate\Support\Str;

function num($number = 0, $type = 'usd')
{
    switch ($type) {
        case 'usd':
            $num = floatval($number);
            break;

        case 'khr':
            $number = (int) $number;
            $num = round($number / 100) * 100;
            // $num = round($number);
            break;

        default:
            $num = (int) $number;
            break;
    }

    return $num;
}

function num_format($number = 0, $type = 'usd', $with_sign = false)
{
    $number = num($number, $type);
    switch ($type) {
        case 'usd':
            $sign = $with_sign ? '$ ' : '';
            $formated = $sign . number_format($number, 2, '.', ',');
            break;

        case 'khr':
            $sign = $with_sign ? ' ៛' : '';
            $formated = number_format($number, 0, '.', ',') . $sign;
            break;

        default:
            $formated = $number;
            break;
    }

    return $formated;
}

function remove_string($str_remove, $string)
{
    return str_replace($str_remove, '', $string);
}

function invite_code($length = 40)
{
    return Str::random($length);
}
