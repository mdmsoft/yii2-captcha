<?php

namespace mdm\captcha\equations;

/**
 * Integral 1
 *
 * Integrate[x = 0 to a, x^2 + 2bx + c]
 *
 * = x^3/3 + bx^2 + cx , x = 0 to a
 *
 * = [a^3]/3 + b*[a^2] + c*a
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Integrate1
{

    public static function format($code)
    {
        $a = $code[1] + 1;
        $b = $code[2] + 1;
        $c = $code[4] + 1;

        return [$a, $b, $c];
    }

    public static function getExpresion($code, $decimal = false)
    {
        list($a, $b, $c) = static::format($code);
        $b *= 2;
        $f = $decimal ? '' : '3';
        return "int{0}{{$a}}{({$f}x^2 + {$b}x + {$c}) dx}";
    }

    public static function getValue($code, $decimal = false)
    {
        list($a, $b, $c) = static::format($code);
        $f = $decimal ? 1.0 / 3 : 1;
        return ($a * $a * $a) * $f + $b * $a * $a + $c * $a;
    }
}
