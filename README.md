Расширение для smsc.ru
======================
Компонент для отправки смс с помощью сервиса smsc.ru для Yii2.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist rashpil91/yii2-smsc "*"
```

or add

```
"rashpil91/yii2-smsc": "*"
```

to the require section of your `composer.json` file.


Подключение
-----

To use sender, you should configure it in the application configuration like the following, :

```php
'components' => [
	...
        'smsc' => [
            'class' => 'rashpil91\smsc\Smsc',
            'config' => [
                'login' => "", //Ваш логин
                'psw' => "", //Ваш пароль
                'debug' => !1, //Включить режим отладки
                'charset' => 'utf-8'
            ]
        ], 
	...
],
```

Пример
-----

Отправить сообщение

```php
Yii::$app->smsc->Message(89998887766, "Казна пустеет, милорд");
```

Проверить статус сообщения

```php
Yii::$app->smsc-getStatus(89998887766, 1); //Где 1 это ID сообщения, полученный при отправке
```

Данные запроса (Заполняются только при включенном режиме отладки)

```php
Yii::$app->smsc->debug_details;
```

Узнать стоимость сообщения

```php
Yii::$app->smsc->getCost(89998887766, "Казна пустеет, милорд");
```

Баланс

```php
Yii::$app->smsc->getBalance();
```
