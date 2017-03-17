# SwiftMailer Extension for Yii 2 with Spooling

Implements email queue using [SwiftMailer](http://swiftmailer.org/) spool transport and [yii2-swiftmailer](https://github.com/yiisoft/yii2-swiftmailer) extension.

##Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist izumi-kun/yii2-spoolmailer "*"
```

or add

```
"izumi-kun/yii2-spoolmailer": "*"
```

to the require section of your composer.json.

Usage
-----

To use this extension, simply add the following code in your application configuration (both web and console):

```php
return [
    //....
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
    ],
];
```

Add the following code in your console configuration:

```php
return [
    //....
    'controllerMap' => [
        'mail' => 'izumi\spoolmailer\MailController',
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

Since this extension extends [yii2-swiftmailer](https://github.com/yiisoft/yii2-swiftmailer) for further instructions refer to the [related section in the Yii Definitive Guide](http://www.yiiframework.com/doc-2.0/guide-tutorial-mailing.html).

## License

BSD-3-Clause
