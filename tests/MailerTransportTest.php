<?php

namespace tests;

use izumi\spoolmailer\MailerTransport;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class MailerTransportTest extends TestCase
{
    public function testMailerTransport()
    {
        $transport = new MailerTransport($this->getMailer());
        $message = $this->createMessage();
        $failedRecipients = [];
        $cnt = $transport->send($message->getSwiftMessage(), $failedRecipients);
        $this->assertEquals(1, $cnt);
        $this->assertEmpty($failedRecipients);
    }
}
