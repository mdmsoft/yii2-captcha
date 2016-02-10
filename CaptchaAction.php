<?php

namespace mdm\captcha;

use Yii;
use yii\web\Response;
use yii\helpers\Url;

/**
 * Description of CaptchaAction
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class CaptchaAction extends \yii\captcha\CaptchaAction
{
    const JPEG_FORMAT = 'jpeg';
    const PNG_FORMAT = 'png';

    /**
     * Avaliable value are 'jpeg' or 'png'
     * @var string 
     */
    public $imageFormat = self::JPEG_FORMAT;

    /**
     * Dificully level
     * @var int
     */
    public $level = 1;

    /**
     * Font size.
     * @var int
     */
    public $size = 14;

    /**
     * Allow decimal
     * @var boolean 
     */
    public $allowDecimal = false;

    /**
     * Registered equation class
     * @var array
     */
    public static $classes;

    /**
     * @inheritdoc
     */
    public function init()
    {
        
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->request->getQueryParam(self::REFRESH_GET_VAR) !== null) {
            // AJAX request for regenerating code
            $code = $this->getVerifyCode(true);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'hash1' => $this->generateValidationHash($code),
                'hash2' => $this->generateValidationHash(strtolower($code)),
                // we add a random 'v' parameter so that FireFox can refresh the image
                // when src attribute of image tag is changed
                'url' => Url::to([$this->id, 'v' => uniqid()]),
            ];
        } else {
            $this->setHttpHeaders();
            Yii::$app->response->format = Response::FORMAT_RAW;
            return $this->renderImage($this->getVerifyCode(false, true));
        }
    }

    /**
     * @inheritdoc
     */
    public function getVerifyCode($regenerate = false, $code = false)
    {
        $session = Yii::$app->getSession();
        $session->open();
        $name = $this->getSessionKey();
        if ($session[$name] === null || $regenerate) {
            $session[$name . 'code'] = $this->generateVerifyCode();
            $session[$name] = $this->getValue($session[$name . 'code']);
            $session[$name . 'count'] = 1;
        }

        return $code ? $session[$name . 'code'] : $session[$name];
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        $code = $this->getVerifyCode(false, true);
        $value = $this->getValue($code);
        if ($this->allowDecimal) {
            $valid = abs(round($input, 2) - round($value, 2)) <= 0.02;
        } else {
            $valid = $input == $value;
        }

        $session = Yii::$app->getSession();
        $session->open();
        $name = $this->getSessionKey() . 'count';
        $session[$name] = $session[$name] + 1;
        if ($valid || $session[$name] > $this->testLimit && $this->testLimit > 0) {
            $this->getVerifyCode(true);
        }

        return $valid;
    }

    /**
     * @inheritdoc
     */
    protected function generateVerifyCode()
    {
        mt_srand(time());
        $code = [mt_rand(0, 100)];
        for ($i = 1; $i <= 5; $i++) {
            $code[$i] = mt_rand(0, 10);
        }

        return $code;
    }

    /**
     * @inheritdoc
     */
    protected function renderImage($code)
    {
        require __DIR__ . '/mathpublisher.php';

        $formula = new \expression_math(tableau_expression(trim($this->getExpresion($code))));
        $formula->dessine($this->size);

        ob_start();
        switch ($this->imageFormat) {
            case self::JPEG_FORMAT:
                imagejpeg($formula->image);
                break;
            case self::PNG_FORMAT:
                imagepng($formula->image);
                break;
        }
        imagedestroy($formula->image);

        return ob_get_clean();
    }

    /**
     * Sets the HTTP headers needed by image response.
     */
    protected function setHttpHeaders()
    {
        Yii::$app->getResponse()->getHeaders()
            ->set('Pragma', 'public')
            ->set('Expires', '0')
            ->set('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->set('Content-Transfer-Encoding', 'binary')
            ->set('Content-type', "image/{$this->imageFormat}");
    }

    /**
     * Get expresion formula .
     * @param array $code
     * @return string
     */
    protected function getExpresion($code)
    {
        if ($this->fixedVerifyCode !== null) {
            return $this->fixedVerifyCode;
        }
        $class = static::$classes[$this->level][$code[0] % count(static::$classes[$this->level])];
        return $class::getExpresion($code, $this->allowDecimal);
    }

    /**
     * Get value of formula
     * @param array $code
     * @return int|float
     */
    protected function getValue($code)
    {
        if ($this->fixedVerifyCode !== null) {
            return $this->fixedVerifyCode;
        }
        $class = static::$classes[$this->level][$code[0] % count(static::$classes[$this->level])];
        return $class::getValue($code, $this->allowDecimal);
    }
}

//
CaptchaAction::$classes = require(__DIR__ . '/equations/classes.php');
