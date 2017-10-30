SwiftMailer Extension for Yii 2 with Spooling
=============================================

Implements email queue using [SwiftMailer](http://swiftmailer.org/) spool transport and [yii2-swiftmailer](https://github.com/yiisoft/yii2-swiftmailer) extension.

It supported queues based on built-in SwiftMailer spools or [Yii2 Queue Extension](https://github.com/yiisoft/yii2-queue).

[![Latest Stable Version](https://poser.pugx.org/izumi-kun/yii2-spoolmailer/v/stable)](https://packagist.org/packages/izumi-kun/yii2-spoolmailer)
[![Total Downloads](https://poser.pugx.org/izumi-kun/yii2-spoolmailer/downloads)](https://packagist.org/packages/izumi-kun/yii2-spoolmailer)
[![Build Status](https://travis-ci.org/Izumi-kun/yii2-spoolmailer.svg?branch=master)](https://travis-ci.org/Izumi-kun/yii2-spoolmailer)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Izumi-kun/yii2-spoolmailer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Izumi-kun/yii2-spoolmailer/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Izumi-kun/yii2-spoolmailer/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Izumi-kun/yii2-spoolmailer/?branch=master)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist izumi-kun/yii2-spoolmailer
```

or add

```
"izumi-kun/yii2-spoolmailer": "~1.0.0"
```

to the require section of your composer.json.

Basic Usage
-----------

This way uses built-in SwiftMailer spools: **FileSpool** (default) or **MemorySpool**.

Add the following code in your application configuration (both web and console):

```php
return [
    //....
    'components' => [
        //....
        'mailer' => [
            'class' => izumi\spoolmailer\Mailer::class,
        ],
    ],
];
```

Add the following code in your console configuration:

```php
return [
    //....
    'controllerMap' => [
        'mail' => izumi\spoolmailer\MailController::class,
    ],
];
```

You can then add an email in queue as follows:

```php
Yii::$app->mailer->compose('contact/html')
     ->setFrom('from@domain.com')
     ->setTo($form->email)
     ->setSubject($form->subject)
     ->queue();
```

Process email queue by follow console command:

```
./yii mail/flush
```

CRON job:

```
* * * * * php /var/www/yii-app/yii mail/flush >/dev/null 2>&1
```

Advanced Usage
--------------

This way requires [Yii2 Queue Extension](https://github.com/yiisoft/yii2-queue) in your application. 

Add the following code in your application configuration (both web and console):

```php
return [
    //....
    'components' => [
        //....
        'mailer' => [
            'class' => izumi\spoolmailer\Mailer::class,
            'spoolMailer' => [
                'class' => izumi\spoolmailer\spools\QueueSpool::class,
                'queue' => 'queue', // the application component ID of the queue object
            ],
        ],
    ],
];
```

For more details see the [Yii2 Queue Guide](https://github.com/yiisoft/yii2-queue/blob/master/docs/guide/README.md).

License
-------

BSD-3-Clause
