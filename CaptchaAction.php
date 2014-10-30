<?php

namespace mdm\captcha;

use \Yii;
use yii\helpers\Url;
use yii\web\Response;

/**
 * Description of CaptchaAction 2520
 *
 * @author MDMunir
 */
class CaptchaAction extends \yii\captcha\CaptchaAction
{
    public $level = 1;
    public $size = 14;

    /**
     *
     * @var Formula 
     */
    private $_formula;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->_formula = new Formula($this->level);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->request->getQueryParam(self::REFRESH_GET_VAR) !== null) {
            // AJAX request for regenerating code
            $code = $this->getVerifyCode(true);

            return json_encode([
                'hash1' => $this->generateValidationHash($code),
                'hash2' => $this->generateValidationHash(strtolower($code)),
                // we add a random 'v' parameter so that FireFox can refresh the image
                // when src attribute of image tag is changed
                'url' => Url::to([$this->id, 'v' => uniqid()]),
            ]);
        } else {
            $this->setHttpHeaders();
            Yii::$app->response->format = Response::FORMAT_RAW;
            return $this->renderImage($this->_formula->getExpresion($this->getFormulaCode()));
        }
    }

    /**
     * Gets the verification code.
     * @param boolean $regenerate whether the verification code should be regenerated.
     * @return string the verification code.
     */
    public function getVerifyCode($regenerate = false)
    {
        $session = Yii::$app->getSession();
        $session->open();
        $name = $this->getSessionKey();
        if ($session[$name] === null || $regenerate) {
            $code = $session[$name . 'code'] = $this->generateVerifyCode();
            $session[$name] = $this->_formula->getValue($code);
            $session[$name . 'count'] = 1;
        }
        return $session[$name];
    }

    protected function getFormulaCode()
    {
        $session = Yii::$app->getSession();
        $session->open();
        $name = $this->getSessionKey();
        if ($session[$name] === null) {
            $code = $session[$name . 'code'] = $this->generateVerifyCode();
            $session[$name] = $this->_formula->getValue($code);
            $session[$name . 'count'] = 1;
        }
        return $session[$name . 'code'];
    }

    protected function generateVerifyCode()
    {
        if ($this->fixedVerifyCode !== null) {
            return $this->fixedVerifyCode;
        }
        mt_srand(time());
        $code = [];
        for ($i = 0; $i <= 5; $i++) {
            $code[$i] = mt_rand(0, 10);
        }
        $code[6]=  mt_rand(0, 100);
        return $code;
    }

    protected function renderImage($code)
    {
        require __DIR__ . '/mathpublisher.php';

        $formula = new \expression_math(tableau_expression(trim($code)));
        $formula->dessine($this->size);

        ob_start();
        imagepng($formula->image);
        imagedestroy($formula->image);

        return ob_get_clean();
    }
}