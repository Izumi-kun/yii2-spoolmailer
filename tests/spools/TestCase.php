<?php

namespace tests\spools;

use izumi\spoolmailer\spools\BaseSpool;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
abstract class TestCase extends \tests\TestCase
{
    /**
     * @return BaseSpool|object
     */
    abstract public function getSpool();

    public function queueMessage()
    {
        $message = $this->createMessage();
        $done = $this->getSpool()->send($message);
        $this->assertTrue($done);
        return $message;
    }

    public function testFlush()
    {
        $message = $this->queueMessage();
        $this->getSpool()->flush($this->getMailer());

        $this->assertMessageSent($message);
    }
}
