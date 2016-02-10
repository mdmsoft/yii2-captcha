<?php

namespace mdm\captcha\equations;

/**
 * Multiply
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Division
{

    protected static function format($code)
    {
        $a = $code[1] + $code[2] + $code[3] * $code[5];
        $b = $code[3] + $code[4] + 12;
        $c = $code[2] + $code[4] + $code[5] + 1;

        return [$a + $b - $c, $c];
    }

    public static function getExpresion($code, $decimal = false)
    {
        list($a, $b) = static::format($code);
        $a = $decimal ? $a : $a * $b;
        return "{$a} / {$b}";
    }

    public static function getValue($code, $decimal = false)
    {
        list($a, $b) = static::format($code);
        return $decimal ? 1.0 * $a / $b : $a;
    }
}
