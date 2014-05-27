Captcha With Math Equation
==========================

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
![screenshot](https://lh3.googleusercontent.com/-ACmPR-FSnfE/U4Rz2f3tqqI/AAAAAAAAAgw/D6xuLeobLU4/w804-h496-no/Screenshot+from+2014-05-27+16%253A47%253A07.png)
