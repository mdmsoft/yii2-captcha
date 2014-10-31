<?php

namespace mdm\captcha\equations;

/**
 * Polynomial Orde 2
 * 
 * Limit a^2 + b*c - d
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Polynom2 implements EquationInterface
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
        return [$a, $b + 11, $code[4] % 3 + 1];
    }

    public static function getExpresion($code)
    {
        list($a, $b, $c) = static::format($code);
        $sb = $c * $b;
        return "{$a}^2 + {$sb} - {$b}";
    }

    public static function getValue($code)
    {
        list($a, $b, $c) = static::format($code);
        return $a * $a + $c * $b - $b;
    }
}