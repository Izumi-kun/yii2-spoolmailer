<?php

namespace tests\spools;

use izumi\spoolmailer\spools\QueueSpool;
use Yii;
use yii\base\NotSupportedException;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class QueueSpoolTest extends TestCase
{
    /**
     * @return QueueSpool|object
     */
    public function getSpool()
    {
        return Yii::$app->get('queueSpool');
    }

    public function testFlush()
    {
        $this->expectException(NotSupportedException::class);
        $this->getSpool()->flush($this->getMailer());
    }

    public function testQueueRun()
    {
        $message = $this->queueMessage();
        $this->runProcess('file-queue/run');
        $this->assertMessageSent($message);
    }
}
