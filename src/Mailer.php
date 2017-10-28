<?php

namespace izumi\spoolmailer;

use izumi\spoolmailer\spools\BaseSpool;
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
    public $messageClass = 'izumi\spoolmailer\Message';
    /**
     * @var BaseSpool|string|array
     */
    public $spoolMailer = [
        'class' => 'izumi\spoolmailer\spools\FileSpool',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->spoolMailer = Instance::ensure($this->spoolMailer, BaseSpool::className());
    }

    /**
     * Add the given email message to queue.
     * This method will log a message about the email being queued.
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
