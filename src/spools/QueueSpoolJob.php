<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace izumi\spoolmailer\spools;

use izumi\spoolmailer\ImportedMessage;
use Swift_Message;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\di\Instance;
use yii\mail\BaseMailer;
use yii\queue\JobInterface;
use yii\queue\Queue;

/**
 * Job for QueueSpool.
 *
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class QueueSpoolJob extends BaseObject implements JobInterface
{
    /**
     * @var array|string the application component ID of the mailer object.
     */
    public $mailer = 'mailer';
    /**
     * @var Swift_Message
     */
    public $message;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->message instanceof Swift_Message) {
            throw new InvalidConfigException('The message should be an instance of "Swift_Message".');
        }
    }

    /**
     * @param Queue $queue which pushed and is handling the job
     * @throws InvalidConfigException
     */
    public function execute($queue)
    {
        /** @var BaseMailer $mailer */
        $mailer = Instance::ensure($this->mailer, BaseMailer::class);
        $message = new ImportedMessage($this->message);
        $mailer->send($message);
    }
}
