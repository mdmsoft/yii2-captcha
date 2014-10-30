<?php

namespace mdm\captcha;

/**
 * Formula
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Formula extends \yii\base\Object
{
    public static $classes;
    public $level;

    public function __construct($level, $config = array())
    {
        $this->level = $level;
        parent::__construct($config);
    }

    public function getExpresion($code)
    {
        $idx = $code[6] % count(static::$classes[$this->level]);
        $class = static::$classes[$this->level][$idx];
        return $class::getExpresion($code);
    }

    public function getValue($code)
    {
        $idx = $code[6] % count(static::$classes[$this->level]);
        $class = static::$classes[$this->level][$idx];
        return $class::getValue($code);
    }
}
// avaliable classes
Formula::$classes = require(__DIR__ . DIRECTORY_SEPARATOR . 'equations' . DIRECTORY_SEPARATOR . 'classes.php');
