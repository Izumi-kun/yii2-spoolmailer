<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace tests;

use izumi\spoolmailer\Message;
use izumi\spoolmailer\spools\BaseSpool;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class MailerTest extends TestCase
{
    public function testSpoolMailerClass()
    {
        $mailer = $this->getMailer();
        $this->assertInstanceOf(BaseSpool::class, $mailer->spoolMailer);
    }

    public function testMessageClass()
    {
        $message = $this->createMessage();
        $this->assertInstanceOf(Message::class, $message);
    }

    /**
     * @depends testSpoolMailerClass
     * @depends testMessageClass
     */
    public function testQueue()
    {
        $message = $this->createMessage();
        $success = $this->getMailer()->queue($message);
        $this->assertTrue($success);
    }

    /**
     * @depends testQueue
     */
    public function testFlush()
    {
        $message = $this->createMessage();
        $mailer = $this->getMailer();
        $mailer->queue($message);
        $mailer->flushQueue();
        $this->assertMessageSent($message);
    }
}
