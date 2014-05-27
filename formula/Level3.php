<?php

namespace mdm\captcha\formula;

/**
 * Description of Level5
 *
 * @author MDMunir
 */
class Level3 extends BaseFormula
{

    public function expression($code, $forFormula)
    {
        switch ($code[5] % 4) {
            case 1:
                $a = $code[0] % 3;
                $b = $a + $code[2];
                if ($forFormula) {
                    return "int{{$a}}{{$b}}{(3x^2 - 4x + 2) dx}";
                } else {
                    $fa = $a * $a * $a - 2 * $a * $a + 2 * $a;
                    $fb = $b * $b * $b - 2 * $b * $b + 2 * $b;
                    return $fb - $fa;
                }
                break;

            case 2:
                $a = $code[0];
                $b = $code[1];
                $c = $code[2];
                $d = $a * $b;
                $x1 = $a == $b ? '' : ($a > $b ? '+ ' . ($a - $b) : '- ' . ($b - $a)) . 'x ';
                $x2 = $d == 0 ? '' : ($d > 0 ? '+' . $d : $d);
                if ($forFormula) {
                    return "lim{x right {$c}}{{x^2 {$x1}{$x2}}/{x - {$b}}}";
                } else {
                    return $c + $a;
                }
                break;

            case 3:
                $a = $code[0];
                $b = 2 * $code[1] - $a;

                $c = $code[2] - $code[3];
                $d = $code[3] - $code[4];

                $x1 = $a == 0 ? '' : ($a > 0 ? '+' . $a : $a) . 'x ';
                $x2 = $b == 0 ? '' : ($b > 0 ? '+' . $b : $b) . 'x ';
                $x3 = $c == 0 ? '' : ($c > 0 ? '+' . $c : $c);
                $x4 = $d == 0 ? '' : ($d > 0 ? '+' . $d : $d);
                if ($forFormula) {
                    return "lim{x right infty}{sqrt{x^2 {$x1}{$x3}}-sqrt{x^2 {$x2}{$x4}}}";
                } else {
                    return $code[0] + $code[1];
                }
                break;

            default:
                $a = $code[0];
                $b = 2 * $code[1] - $a;

                $c = $code[2] - $code[3];
                $d = $code[3] - $code[4];

                $x1 = $a == 0 ? '' : ($a > 0 ? '+' . $a : $a) . 'x ';
                $x2 = $b == 0 ? '' : ($b > 0 ? '+' . $b : $b) . 'x ';
                $x3 = $c == 0 ? '' : ($c > 0 ? '+' . $c : $c);
                $x4 = $d == 0 ? '' : ($d > 0 ? '+' . $d : $d);
                if ($forFormula) {
                    return "lim{x right infty}{sqrt{x^2 {$x1}{$x3}}-sqrt{x^2 {$x2}{$x4}}}";
                } else {
                    return $code[0] + $code[1];
                }
                break;
        }
    }
}