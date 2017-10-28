<?php

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
        $message = $this->getMailer()->compose();
        $this->assertInstanceOf(Message::class, $message);
    }
}
