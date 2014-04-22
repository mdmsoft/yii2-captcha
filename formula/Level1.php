<?php

namespace mdm\captcha\formula;

/**
 * Description of Level1
 * Simple expression `a + b - c`
 *
 * @author MDMunir
 */
class Level1 extends BaseFormula
{

    public function expression($code, $forFormula)
    {
        switch ($code[5] % 5) {
            case 1:
                $a = $code[1] + $code[2];
                $b = $code[3] + 11;
                $c = $code[4];
                break;

            case 2:
                $a = $code[1] * $code[2];
                $b = $code[3] + 11;
                $c = $code[4];
                break;

            case 3:
                $a = $code[1] + $code[2];
                $b = 23;
                $c = $code[3] + $code[4];
                break;

            case 4:
                $a = $code[1] * $code[2];
                $b = 23;
                $c = $code[3] + $code[4];
                break;

            default:
                $a = 2 * ($code[1] + $code[2]);
                $b = 23;
                $c = $code[3] + $code[4];
                break;
        }
        if ($forFormula) {
            return "{$a}+{$b}-{$c}";
        } else {
            return $a + $b - $c;
        }
    }
}