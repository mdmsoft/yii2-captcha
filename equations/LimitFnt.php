<?php

namespace mdm\captcha\equations;

/**
 * Limit
 *
 * (a - b)(a + c) / (a - b)
 * [a^2 + (c-b)*a - b*c] / [a - b]
 * a + b
 *
 * Limit[x -> a, (x^2 + (c-b)x - b*c)/(x - b)]
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class LimitFnt
{

    protected static function format($code)
    {
        $a = $code[1] + $code[2] + 1;
        $b = $code[3] + $code[4] + 1;
        $c = $code[4] + $code[5] + 1;

        return [$a, $b, $c];
    }

    public static function getExpresion($code)
    {
        list($a, $b, $c) = static::format($code);
        $midle = $c > $b ? '+ ' . ($c - $b) . 'x' : ($c < $b ? '- ' . ($b - $c) . 'x' : '');
        $bc = $b * $c;

        return "lim{x right {$a}}{{x^2 {$midle} - {$bc}}/{x - {$b}}}";
    }

    public static function getValue($code)
    {
        list($a,, $c) = static::format($code);
        return $a + $c;
    }
}
