<?php

namespace tests;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class MailControllerTest extends TestCase
{
    public function testFlush()
    {
        $message = $this->createMessage();
        $this->getMailer()->queue($message);

        $this->assertMessageNotSent($message);

        $this->runProcess('mail/flush');

        $this->assertMessageSent($message);
    }
}
