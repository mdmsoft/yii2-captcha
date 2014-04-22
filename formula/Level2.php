<?php

namespace mdm\captcha\formula;

/**
 * Description of Level2
 * Simple expression `(a + b - c)/(d - e)`
 *
 * @author MDMunir
 */
class Level2 extends BaseFormula
{

    public function expression($code, $forFormula)
    {
        switch ($code[5] % 5) {
            case 1:
                $d = 11 + $code[0];
                $e = $code[1];
                $x = $code[2];
                $y = $code[3];
                $a = $x * $d;
                $b = $y * ($d - $e);
                $c = $x * $e;
                break;

            case 2:
                $d = 23 + $code[0];
                $e = $code[1] + $code[4];
                $x = $code[2];
                $y = $code[3];
                $a = $x * $d;
                $b = $y * ($d - $e);
                $c = $x * $e;
                break;

            case 3:
                $d = 11 + $code[0];
                $e = $code[1];
                $x = $code[2] + $code[4];
                $y = $code[3];
                $a = $x * $d;
                $b = $y * ($d - $e);
                $c = $x * $e;
                break;

            case 4:
                $d = 11 + $code[0];
                $e = $code[1];
                $x = $code[2] * 3;
                $y = $code[3];
                $a = $x * $d;
                $b = $y * ($d - $e);
                $c = $x * $e;
                break;

            default:
                $d = 11 + $code[0];
                $e = $code[1];
                $x = $code[2] - $code[4] + 15;
                $y = $code[3];
                $a = $x * $d;
                $b = $y * ($d - $e);
                $c = $x * $e;
                break;
        }
        if ($forFormula) {
            return "{{$a}+{$b}-{$c}}/{{$d}-{$e}}";
        } else {
            return $x + $y;
        }
    }
}