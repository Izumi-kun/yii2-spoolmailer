<?php

namespace izumi\tests\spoolmailer;

use izumi\spoolmailer\Mailer;

class MailerTest extends TestCase
{
    public function setUp()
    {
        $this->mockApplication();
    }

    public function testSpoolTransport()
    {
        $mailer = new Mailer();

        $transport = $mailer->getSpoolTransport();
        $this->assertEquals('Swift_SpoolTransport', get_class($transport), 'Invalid transport class!');
        $spool = $transport->getSpool();
        $this->assertEquals('Swift_FileSpool', get_class($spool), 'Invalid spool class!');
    }

    /**
     * @depends testSpoolTransport
     */
    public function testSwiftSpoolMailer()
    {
        $mailer = new Mailer();

        $spoolMailer = $mailer->getSwiftSpoolMailer();
        $this->assertEquals('Swift_Mailer', get_class($spoolMailer), 'Invalid mailer class!');
    }
}
