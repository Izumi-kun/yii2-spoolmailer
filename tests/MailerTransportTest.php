<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace tests;

use izumi\spoolmailer\MailerTransport;
use Swift_Plugins_ThrottlerPlugin;
use yii\base\NotSupportedException;

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

    public function testStartStop()
    {
        $transport = new MailerTransport($this->getMailer());
        $transport->stop();
        $transport->start();
        $this->assertTrue($transport->ping());
    }

    public function testRegisterPlugin()
    {
        $transport = new MailerTransport($this->getMailer());
        $plugin = new Swift_Plugins_ThrottlerPlugin(1);

        $this->expectException(NotSupportedException::class);
        $transport->registerPlugin($plugin);
    }
}
