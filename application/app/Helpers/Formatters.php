<?php

namespace App\Helpers;


class Formatters
{

    /**
     * @param $value
     * @return string
     */
    public static function date2db($value)
    {
        return implode('-', array_reverse(explode('/', $value)));
    }

    /**
     * @param $value
     * @return string|string[]|null
     */
    public static function onlyNumber($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

}