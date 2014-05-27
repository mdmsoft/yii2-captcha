mdm-captcha
===========

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mdmsoft/yii2-captcha "*"
```

or add

```
"mdmsoft/yii2-captcha": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply modify your controler, add or change methode `actions()`:

```php
public function actions()
{
	return [
		...
		'captcha' => [
                'class' => 'mdm\captcha\CaptchaAction',
                'level' => 3, // avaliable level are 1,2,3 :D
            ],
	];
}
```