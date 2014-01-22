<?php

namespace mdm\captcha;
use \Yii;
/**
 * Description of CaptchaAction
 *
 * @author MDMunir
 */
class CaptchaAction extends \yii\captcha\CaptchaAction
{

	public $level = 1;
	private $_formula;

	public function init()
	{
		parent::init();
		$this->_formula = require(__DIR__.'/formula/formula'.$this->level.'.php');
	}

	public function run()
	{
		if (isset($_GET[self::REFRESH_GET_VAR])) {
			// AJAX request for regenerating code
			$code = $this->getVerifyCode(true);
			/** @var \yii\web\Controller $controller */
			$controller = $this->controller;
			return json_encode([
				'hash1' => $this->generateValidationHash($code),
				'hash2' => $this->generateValidationHash(strtolower($code)),
				// we add a random 'v' parameter so that FireFox can refresh the image
				// when src attribute of image tag is changed
				'url' => $controller->createUrl($this->id, ['v' => uniqid()]),
			]);
		} else {
			$this->setHttpHeaders();
			$code = $this->getFormulaCode();
			$callback = $this->_formula[$code[5]][0];
			return $this->renderImage(call_user_func($callback, $code));
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
			$callback = $this->_formula[$code[5]][1];
			$session[$name] = call_user_func($callback, $code);
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
			$callback = $this->_formula[$code[5]][1];
			$session[$name] = call_user_func($callback, $code);
			$session[$name . 'count'] = 1;
		}
		return $session[$name . 'code'];
	}

	protected function generateVerifyCode()
	{
		if ($this->fixedVerifyCode !== null) {
			return $this->fixedVerifyCode;
		}

		$code = [];
		for ($i = 0; $i < 5; $i++) {
			$code[] = mt_rand(0, 10);
		}
		$code[] = mt_rand(0, count($this->_formula) - 1);
		return $code;
	}
	
	protected function renderImage($code)
	{
		$url = "http://latex.codecogs.com/png.latex?\dpi{{$this->width}}&space;\bg_white&space;$code";
		echo file_get_contents($url);
	}

}