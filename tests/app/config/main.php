<?php

$config = [
    'id' => 'test-app',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(dirname(__DIR__))) . '/vendor',
    'bootstrap' => [
        'fileQueue',
    ],
    'controllerMap' => [
        'mail' => izumi\spoolmailer\MailController::class,
    ],
    'components' => [
        'fileQueue' => [
            'class' => yii\queue\file\Queue::class,
        ],
        'mailer' => [
            'class' => izumi\spoolmailer\Mailer::class,
            'useFileTransport' => true,
            'fileTransportCallback' => function (yii\mail\BaseMailer $mailer, yii\mail\MessageInterface $message) {
                return $message->getSubject() ? : $mailer->generateMessageFileName();
            }
        ],
        'fileSpool' => [
            'class' => izumi\spoolmailer\spools\FileSpool::class,
        ],
        'memorySpool' => [
            'class' => izumi\spoolmailer\spools\MemorySpool::class,
        ],
        'queueSpool' => [
            'class' => izumi\spoolmailer\spools\QueueSpool::class,
            'queue' => 'fileQueue',
        ],
    ],
];

return $config;
