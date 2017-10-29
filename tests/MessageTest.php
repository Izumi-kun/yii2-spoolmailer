<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace tests;

use izumi\spoolmailer\Mailer;
use izumi\spoolmailer\Message;
use izumi\spoolmailer\spools\MemorySpool;
use yii\base\InvalidConfigException;
use yii\mail\MailEvent;
use yii\swiftmailer\Mailer as SwiftMailer;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class MessageTest extends TestCase
{
    public function testQueueWithWrongMailer()
    {
        $message = new Message(['mailer' => new SwiftMailer()]);

        $this->expectException(InvalidConfigException::class);
        $message->queue();
    }

    public function testDefaultMailer()
    {
        $message = new Message();
        $result = $message->queue();
        $this->assertTrue($result);
    }

    public function testPropMailer()
    {
        $message = new Message();
        $usedAnotherMailer = false;
        $anotherMailer = new Mailer([
            'spoolMailer' => [
                'class' => MemorySpool::class,
                'on afterSend' => function (MailEvent $event) use (&$usedAnotherMailer, $message) {
                    if ($event->message === $message) {
                        $usedAnotherMailer = true;
                    }
                },
            ],
        ]);
        $message->mailer = $anotherMailer;
        $message->queue();
        $this->assertTrue($usedAnotherMailer);
    }

    public function testArgMailer()
    {
        $message = new Message();
        $usedAnotherMailer = false;
        $propMailer = new Mailer([
            'spoolMailer' => [
                'class' => MemorySpool::class,
                'on afterSend' => function (MailEvent $event) use (&$usedAnotherMailer, $message) {
                    if ($event->message === $message) {
                        $usedAnotherMailer = true;
                    }
                },
            ],
        ]);
        $usedPropMailer = false;
        $argMailer = new Mailer([
            'spoolMailer' => [
                'class' => MemorySpool::class,
                'on afterSend' => function (MailEvent $event) use (&$usedPropMailer, $message) {
                    if ($event->message === $message) {
                        $usedPropMailer = true;
                    }
                },
            ],
        ]);
        $message->mailer = $propMailer;
        $message->queue($argMailer);
        $this->assertFalse($usedAnotherMailer);
        $this->assertTrue($usedPropMailer);
    }
}
