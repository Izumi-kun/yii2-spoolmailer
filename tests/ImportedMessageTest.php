<?php

namespace izumi\tests\spoolmailer;

use izumi\spoolmailer\ImportedMessage;
use izumi\spoolmailer\Mailer;
use izumi\spoolmailer\Message;
use Yii;
use yii\mail\MessageInterface;

class ImportedMessageTest extends TestCase
{
    public function setUp()
    {
        $this->mockApplication([
            'components' => [
                'mailer' => [
                    'class' => Mailer::className(),
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

    public function testImportedMessage()
    {
        $message = $this->createTestMessage();
        $message->setSubject('Test imported message');
        $swiftMessage = $message->getSwiftMessage();
        $importedMessage = new ImportedMessage($swiftMessage);
        $this->assertEquals($swiftMessage, $importedMessage->getSwiftMessage());
        $this->assertEquals($message->getSubject(), $importedMessage->getSubject());
    }

}
