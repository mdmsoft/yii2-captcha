<?php

namespace mdm\captcha\equations;

/**
 * AddSub
 * Simple math equation like `$a + $b - $c`
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class AddSub
{

    protected static function format($code)
    {
        $a = $code[1] + $code[2] + $code[3] * $code[5];
        $b = $code[3] + $code[4] + 12;
        $c = $code[2] + $code[4] + $code[5] + 1;

        return [$a, $b, $c];
    }

    public static function getExpresion($code)
    {
        list($a, $b, $c) = static::format($code);
        return "{$a}+{$b}-{$c}";
    }

    public static function getValue($code)
    {
        list($a, $b, $c) = static::format($code);
        return $a + $b - $c;
    }
}
