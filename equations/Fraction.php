<?php

namespace mdm\captcha\equations;

/**
 * Polynomial Orde 2
 *
 * (a - b)(a + 2 + c) / (a + 2 + c)
 * [a^2 + (c-b+2)*a - b*(c+2)] / [a + 2 + c]
 * a -b
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Fraction
{

    protected static function format($code)
    {
        $a = $code[1] + $code[2] + 1;
        $b = $code[3] + $code[4] + 1;
        $c = $code[4] + $code[5] + 1;

        return [$a, $b, $c];
    }

    public static function getExpresion($code, $decimal = false)
    {
        list($a, $b, $c) = static::format($code);
        $a += $b;

        $c2 = $c + 2;
        $midle = $c2 > $b ? '+ ' . ($c2 - $b) . "*{$a}" : ($c2 < $b ? '- ' . ($b - $c2) . "*{$a}" : '');
        $bc = $b * $c2;

        if ($decimal) {
            $c += 3;
        }
        $a2 = $a + 2;
        return "{{$a}^2 {$midle} - {$bc}} / {{$a2} + {$c}}";
    }

    public static function getValue($code, $decimal = false)
    {
        list($a, $b, $c) = static::format($code);
        if ($decimal) {
            $a += $b;
            return 1.0 * ($a - $b) * ($a + 2 + $c) / ($a + $c + 5);
        } else {
            return $a;
        }
    }
}
