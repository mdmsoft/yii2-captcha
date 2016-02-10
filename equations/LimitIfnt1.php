<?php

namespace mdm\captcha\equations;

/**
 * Limit Infinity 1
 *
 * Limit[x -> ~,V(x^2 + ax + c) - V(x^2 + bx + d)]
 *
 * (a - b)/2
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class LimitIfnt1
{

    protected static function format($code)
    {
        $a = $code[1] + $code[2] + 10;
        $b = $code[3] + $code[4] - 10;
        $c = $code[4] + $code[5] + 1;
        $d = $code[1] + $code[5] + 1;

        return [$a, $b, $c, $d];
    }

    public static function getExpresion($code, $decimal = false)
    {
        list($a, $b, $c, $d) = static::format($code);
        if (!$decimal) {
            $a *= 2;
        }
        $a += $b;
        $sb = $b > 0 ? "+ {$b}x" : ($b < 0 ? '- ' . abs($b) . 'x' : '');
        $sg1 = $c > 10 ? '+' : '-';
        $sg2 = $d > 10 ? '+' : '-';
        return "lim{x right infty}{sqrt{x^2 + {$a}x {$sg1} {$c}}-sqrt{x^2 {$sb} {$sg2} {$d}}}";
    }

    public static function getValue($code, $decimal = false)
    {
        list($a,,, ) = static::format($code);
        return $decimal ? $a / 2 : $a;
    }
}
