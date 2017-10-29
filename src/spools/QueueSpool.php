<?php

namespace izumi\spoolmailer\spools;

use Swift_Mime_SimpleMessage;
use Swift_Spool;
use Swift_SpoolTransport;
use Swift_Transport;
use Yii;
use yii\base\NotSupportedException;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\mail\BaseMailer;
use yii\queue\Queue;

/**
 * Stores Messages using Queue Jobs.
 *
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class QueueSpool extends BaseSpool implements Swift_Spool
{
    /**
     * @var Queue|array|string the queue object or the application component ID of the queue object.
     */
    public $queue = 'queue';
    /**
     * @var array the default configuration of jobs.
     */
    public $jobConfig = ['class' => QueueSpoolJob::class];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->queue = Instance::ensure($this->queue, Queue::className());
        parent::init();
        $this->setTransport([
            'class' => Swift_SpoolTransport::class,
            'constructArgs' => [$this],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function flush(BaseMailer $mailer, &$failedRecipients = null)
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function start()
    {
    }

    /**
     * @inheritdoc
     */
    public function stop()
    {
    }

    /**
     * @inheritdoc
     */
    public function isStarted()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function queueMessage(Swift_Mime_SimpleMessage $message)
    {
        $config = ArrayHelper::merge($this->jobConfig, ['message' => $message]);
        $job = Yii::createObject($config);

        return $this->queue->push($job) !== null;
    }

    /**
     * @inheritdoc
     */
    public function flushQueue(Swift_Transport $transport, &$failedRecipients = null)
    {
        throw new NotSupportedException();
    }
}
