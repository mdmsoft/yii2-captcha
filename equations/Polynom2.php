<?php

namespace mdm\captcha\equations;

/**
 * Polynomial Orde 2
 * 
 * Limit a^2 + b*c - (b-2)
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Polynom2
{

    protected static function format($code)
    {
        $a = $code[1] + $code[2] + 1;
        $b = $code[3] + $code[4] + 3;
        $c = $code[3] + $code[4] + $code[5] + 1;

        return [$a, $b, $c];
    }

    public static function getExpresion($code)
    {
        list($a, $b, $c) = static::format($code);
        $b2 = $b - 2;
        return "{$a}^2 + {$b}*{$c} - {$b2}";
    }

    public static function getValue($code)
    {
        list($a, $b, $c) = static::format($code);
        return $a * $a + $b * $c - ($b - 2);
    }
}
