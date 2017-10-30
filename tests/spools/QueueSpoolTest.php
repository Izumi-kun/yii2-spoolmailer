<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

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

    public function testFlushQueue()
    {
        $this->expectException(NotSupportedException::class);
        $this->getSpool()->flushQueue($this->getMailer()->getTransport());
    }

    public function testQueueRun()
    {
        $message = $this->queueMessage();
        $this->runProcess('file-queue/run');
        $this->assertMessageSent($message);
    }

    public function testStopStart()
    {
        $spool = $this->getSpool();
        $spool->stop();
        $spool->start();
        $this->assertTrue($spool->isStarted());
    }

    public function testJobId()
    {
        $this->queueMessage();
        $spool = $this->getSpool();
        $jobId = $spool->getLastJobId();
        $this->assertFalse($spool->queue->isDone($jobId));
        $this->runProcess('file-queue/run');
        $this->assertTrue($spool->queue->isDone($jobId));
    }
}
