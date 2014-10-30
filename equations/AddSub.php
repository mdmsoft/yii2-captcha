<?php

namespace mdm\captcha\equations;

/**
 * AddSub
 * Simple math equation like `$a + $b - $c`
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class AddSub implements EquationInterface
{

    protected static function format($code)
    {
        switch ($code[5] % 5) {
            case 0:
                $a = $code[1] + $code[2];
                $b = $code[3] + 11;
                $c = $code[4];
                break;

            case 1:
                $a = $code[1] * $code[2];
                $b = $code[3] + 11;
                $c = $code[4];
                break;

            case 2:
                $a = $code[1] + $code[2];
                $b = $code[3] + 11;
                $c = $code[3] + $code[4];
                break;

            case 3:
                $a = $code[1] * $code[2];
                $b = $code[3] + 11;
                $c = $code[3] + $code[4];
                break;

            default:
                $a = 2 * ($code[1] + $code[2]);
                $b = $code[3] + 11;
                $c = $code[3] + $code[4];
                break;
        }
        return [$a, $b, $c];
    }

    public static function getExpresion($code)
    {
        list($a, $b, $c) = static::format($code);
        return "{$a}+{$b}-{$c}";
    }

    public static function getValue($code)
    {
        list($a, $b, $c) = static::format($code);
        return $a + $b - $c;
    }
}