<?php

namespace mdm\captcha\equations;

/**
 * Multiply
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class LimitIfnt1 implements EquationInterface
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
        return [2 * $a + $b, $b, $code[0] - $code[2]+11, $code[1] - $code[3]+11];
    }

    public static function getExpresion($code)
    {
        list($a, $b, $c, $d) = static::format($code);
        $sg1 = $c > 10? '+' : '-';
        $sg2 = $d > 10? '+' : '-';
        return "lim{x right infty}{sqrt{x^2 + {$a}x {$sg1} {$c}}-sqrt{x^2 + {$b}x {$sg2} {$d}}}";
    }

    public static function getValue($code)
    {
        list($a, $b,, ) = static::format($code);
        return ($a - $b) / 2;
    }
}