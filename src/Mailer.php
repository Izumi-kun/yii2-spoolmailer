<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace izumi\spoolmailer;

use izumi\spoolmailer\spools\BaseSpool;
use izumi\spoolmailer\spools\FileSpool;
use yii\di\Instance;
use yii\mail\MessageInterface;

/**
 * Mailer with spool.
 *
 * @method Message|MessageInterface compose($view = null, array $params = [])
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class Mailer extends \yii\swiftmailer\Mailer
{
    /**
     * @var string message default class name.
     */
    public $messageClass = Message::class;
    /**
     * @var BaseSpool|string|array
     */
    public $spoolMailer = [
        'class' => FileSpool::class,
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->spoolMailer = Instance::ensure($this->spoolMailer, BaseSpool::class);
    }

    /**
     * Add the given email message to queue.
     * @param MessageInterface $message email message instance to be queued
     * @return bool whether the message has been sent successfully
     */
    public function queue($message)
    {
        return $this->spoolMailer->send($message);
    }

    /**
     * Sends messages.
     * @param string[] $failedRecipients an array of failures by-reference
     * @return int the number of sent emails
     */
    public function flushQueue(&$failedRecipients = null)
    {
        return $this->spoolMailer->flush($this, $failedRecipients);
    }
}
