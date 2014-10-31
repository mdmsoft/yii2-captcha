<?php

namespace mdm\captcha\equations;

/**
 * Multiply
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class LimitIfnt2 implements EquationInterface
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
        return [$a, $b, $code[0] - $code[2] + 11, $code[1] - $code[3] + 11];
    }

    public static function getExpresion($code)
    {
        list($a, $b, $c, $d) = static::format($code);
        $sg1 = $c > 10 ? '+' : '-';
        $sg2 = $d > 10 ? '+' : '-';
        $a1 = $b * $b;
        if ($a1 == 0) {
            $a1 = 4;
        }
        return "lim{x right infty}{sqrt{{$a1}x^2 {$sg2} {$a}x {$sg1} {$c}}}/{sqrt{x^2 {$sg1} {$b}x {$sg2} {$d}}}";
    }

    public static function getValue($code)
    {
        list(, $b,, ) = static::format($code);
        return $b == 0 ? 2 : $b;
    }
}