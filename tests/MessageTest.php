<?php

namespace tests;

use izumi\spoolmailer\Message;
use yii\base\InvalidConfigException;
use yii\swiftmailer\Mailer;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class MessageTest extends TestCase
{
    public function testQueueWithWrongMailer()
    {
        $message = new Message(['mailer' => new Mailer()]);

        $this->expectException(InvalidConfigException::class);
        $message->queue();
    }
}
