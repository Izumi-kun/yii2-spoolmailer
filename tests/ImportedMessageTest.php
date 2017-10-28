<?php

namespace tests;

use izumi\spoolmailer\ImportedMessage;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class ImportedMessageTest extends TestCase
{
    public function testImportedMessage()
    {
        $message = $this->createMessage();
        $swiftMessage = $message->getSwiftMessage();
        $importedMessage = new ImportedMessage($swiftMessage);

        $this->assertEquals($swiftMessage, $importedMessage->getSwiftMessage());
        $this->assertEquals($message->getSubject(), $importedMessage->getSubject());
    }
}
