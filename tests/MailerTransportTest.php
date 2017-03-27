<?php

namespace izumi\tests\spoolmailer;

use izumi\spoolmailer\Mailer;
use izumi\spoolmailer\MailerTransport;
use izumi\spoolmailer\Message;
use Yii;
use yii\mail\MessageInterface;

class MailerTransportTest extends TestCase
{
    public function setUp()
    {
        $this->mockApplication([
            'components' => [
                'mailer' => [
                    'class' => Mailer::className(),
                    'useFileTransport' => true,
                ],
            ],
        ]);
    }

    /**
     * @return Message|MessageInterface test message instance.
     */
    protected function createTestMessage()
    {
        return Yii::$app->mailer->compose();
    }

    public function testMailerTransport()
    {
        $transport = new MailerTransport(Yii::$app->mailer);
        $message = $this->createTestMessage();
        $message->setTo('someuser@somedomain.com');
        $message->setFrom('someuser@somedomain.com');
        $message->setSubject('Test mailer transport');
        $message->setTextBody('Test body');

        $cnt = $transport->send($message->getSwiftMessage());
        $this->assertEquals(1, $cnt, 'Unable to send message!');
    }

}
