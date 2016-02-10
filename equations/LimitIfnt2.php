<?php

namespace mdm\captcha\equations;

/**
 * Limit Infinity 2
 *
 * Limit[x -> ~,V(ax^2 + cx + c) / V(x^2 + dx + d)]
 *
 * Va
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class LimitIfnt2
{

    protected static function format($code)
    {
        $a = $code[1] + $code[2] + 1;
        $b = $code[2] + $code[3] + $code[4] + 1;
        $c = $code[1] + $code[4] + $code[5] + 1;
        $d = $code[1] + $code[5] + 5;

        return [$a, $b, $c, $d];
    }

    public static function getExpresion($code, $decimal = false)
    {
        list($a, $b, $c, $d) = static::format($code);
        if (!$decimal) {
            $a = $a * $a;
        }
        $midle1 = (($b > 15) ? '+' : '-') . " {$b}x + " . ($d - 4);
        $midle2 = (($c > 15) ? '+' : '-') . " {$c}x - " . ($d + 4);

        return "lim{x right infty}{{sqrt{{$a}x^2 {$midle1}}}/{sqrt{x^2 {$midle2}}}}";
    }

    public static function getValue($code, $decimal = false)
    {
        list($a,,, ) = static::format($code);
        return $decimal ? sqrt($a) : $a;
    }
}
