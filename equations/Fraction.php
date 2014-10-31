<?php

namespace mdm\captcha\equations;

/**
 * Polynomial Orde 2
 * 
 * Limit [a^2 + b*c + d]/[e + f]
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Fraction implements EquationInterface
{

    protected static function format($code)
    {
        switch ($code[5] % 5) {
            case 0:
                $a = $code[0] + $code[1];
                $b = $code[2] + $code[3];
                break;
            case 1:
                $a = $code[0] - $code[1] + 11;
                $b = $code[2] + $code[3];
                break;
            case 2:
                $a = $code[0] + $code[1];
                $b = $code[2] - $code[3];
                break;
            case 3:
                $a = $code[0] - $code[1] + 11;
                $b = $code[2] - $code[3];
                break;
            default :
                $a = $code[0] - $code[1] + 11;
                $b = $code[2] * $code[4] - $code[3];
                break;
        }
        return [$a + 11, $b];
    }

    public static function getExpresion($code)
    {
        list($a, $b) = static::format($code);
        if ($b == 0) {
            $b++;
        }
        $sign = $b > 0 ? '+' : '-';
        $ab = 2 * abs($a * $b);
        $bb = $b * $b;
        $b = abs($b);
        return "{{$a}^2 {$sign} {$ab} + {$bb}} / {{$a} {$sign} {$b}}";
    }

    public static function getValue($code)
    {
        list($a, $b) = static::format($code);
        return $a + $b;
    }
}