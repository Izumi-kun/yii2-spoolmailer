<?php

namespace izumi\spoolmailer;

use Swift_Events_EventListener;
use Swift_Mime_Message;
use yii\base\InvalidParamException;
use yii\mail\MailerInterface;

/**
 * Sends Messages using the `MailerInterface`.
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class MailerTransport implements \Swift_Transport
{
    /**
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * FileTransport constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @inheritdoc
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        if (!$message instanceof \Swift_Message) {
            throw new InvalidParamException('The message should be an instance of "Swift_Message".');
        }
        $failedRecipients = (array) $failedRecipients;
        $importedMessage = new ImportedMessage($message);

        if ($this->mailer->send($importedMessage)) {
            return count($importedMessage->getTo());
        } else {
            $failedRecipients = (array) $importedMessage->getTo();
            return 0;
        }
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
    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
    }
}
