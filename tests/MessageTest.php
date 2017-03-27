<?php

namespace izumi\tests\spoolmailer;

use izumi\spoolmailer\Mailer;
use izumi\spoolmailer\MailerTransport;
use izumi\spoolmailer\Message;
use Yii;
use yii\mail\MailerInterface;
use yii\mail\MessageInterface;

class MessageTest extends TestCase
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

    /**
     * @return Mailer|MailerInterface
     */
    protected function getMailer()
    {
        return Yii::$app->mailer;
    }

    /**
     * @return \Swift_FileSpool|\Swift_Spool
     */
    protected function getSpool()
    {
        return $this->getMailer()->getSpoolTransport()->getSpool();
    }

    public function testMessage()
    {
        $message = $this->createTestMessage();
        $this->assertTrue($message instanceof Message, 'Invalid message class!');
    }

    /**
     * @depends testMessage
     */
    public function testQueue()
    {
        $message = $this->createTestMessage();
        $message->setTo('someuser@somedomain.com');
        $message->setFrom('someuser@somedomain.com');
        $message->setSubject('Test');
        $message->setTextBody('Test body');
        $this->assertTrue($message->queue());
    }

    /**
     * @depends testQueue
     */
    public function testFlush()
    {
        $spool = $this->getSpool();
        $transport = new MailerTransport($this->getMailer());
        $this->assertTrue($spool->flushQueue($transport) > 0);
    }
}
