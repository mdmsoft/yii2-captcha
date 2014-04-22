<?php
namespace mdm\captcha\formula;
/**
 * Description of BaseFormula
 *
 * @author MDMunir
 */
abstract class BaseFormula
{
    abstract public function expression($code,$forFormula);
}