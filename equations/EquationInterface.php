<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace mdm\captcha\equations;

/**
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
interface EquationInterface
{
    /**
     * Return mathematic expresion to be rendered
     * @param string $code
     * @return string
     */
    public static function getExpresion($code);

    /**
     * Value of expresion
     * @param string $code
     * @return string
     */
    public static function getValue($code);
}