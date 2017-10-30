<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

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
     * @var null|string id of the last added job message.
     */
    private $_lastJobId;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->queue = Instance::ensure($this->queue, Queue::className());
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
     * @return null|string id of the last added job message.
     */
    public function getLastJobId()
    {
        return $this->_lastJobId;
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
        $this->_lastJobId = $this->queue->push($job);

        return $this->_lastJobId !== null;
    }

    /**
     * @inheritdoc
     */
    public function flushQueue(Swift_Transport $transport, &$failedRecipients = null)
    {
        throw new NotSupportedException();
    }
}
