<?php

namespace mdm\captcha\equations;

/**
 * Multiply
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class LimitFnt implements EquationInterface
{

    public static function format($code)
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
                $b = $code[2] - $code[3] + 11;
                break;
            case 3:
                $a = $code[0] - $code[1] + 11;
                $b = $code[2] - $code[3] + 11;
                break;
            default :
                $a = $code[0] - $code[1] + 11;
                $b = $code[2] - $code[3] + $code[4] + 11;
                break;
        }
        return [$a, $b, $code[0] == '0' ? 1 : $code[0]];
    }

    public static function getExpresion($code)
    {
        list($a, $b, $c) = static::format($code);
        $sign = $c > $b ? ' + ' : ($c < $b ? ' - ' : '');
        if ($sign != '') {
            $bc1 = abs($c - $b);
            $bc1 = $bc1 == 1 ? 'x' : $bc1 . 'x';
        } else {
            $bc1 = '';
        }
        $bc2 = $b * $c;
        return "lim{x right {$a}}{{x^2{$sign}{$bc1} - {$bc2}}/{x - {$b}}}";
    }

    public static function getValue($code)
    {
        list($a,, $c) = static::format($code);
        return $a + $c;
    }
}