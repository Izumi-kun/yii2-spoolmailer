<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace tests;

use izumi\spoolmailer\MailerTransport;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class MailerTransportTest extends TestCase
{
    public function testSuccessSend()
    {
        $transport = new MailerTransport($this->getMailer());
        $message = $this->createMessage();
        $failedRecipients = [];
        $cnt = $transport->send($message->getSwiftMessage(), $failedRecipients);
        $this->assertEquals(1, $cnt);
        $this->assertEmpty($failedRecipients);
    }

    public function testFailedSend()
    {
        $transport = new MailerTransport($this->getMailer());
        $message = $this->createInvalidMessage();
        $failedRecipients = [];
        $cnt = $transport->send($message->getSwiftMessage(), $failedRecipients);
        $this->assertEquals(0, $cnt);
        $this->assertNotEmpty($failedRecipients);
    }
}
