<?php

namespace izumi\spoolmailer;

use Yii;
use yii\mail\MailEvent;
use yii\mail\MessageInterface;

/**
 * Spool Mailer
 * @property \Swift_SpoolTransport $spoolTransport This property is read-only.
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class Mailer extends \yii\swiftmailer\Mailer
{
    /**
     * @event MailEvent an event raised right before adding to queue.
     * You may set [[MailEvent::isValid]] to be false to cancel the queueing.
     */
    const EVENT_BEFORE_QUEUE = 'beforeQueue';
    /**
     * @event MailEvent an event raised right after adding to queue.
     */
    const EVENT_AFTER_QUEUE = 'afterQueue';

    /**
     * @var string message default class name.
     */
    public $messageClass = 'izumi\spoolmailer\Message';
    /**
     * @var string
     */
    public $spoolPath = '@runtime/mail_spool';

    /**
     * @var \Swift_Mailer Swift mailer instance with Spool Transport.
     */
    private $_swiftSpoolMailer;
    /**
     * @var \Swift_SpoolTransport Swift transport instance or its array configuration.
     */
    private $_spoolTransport;

    /**
     * @inheritdoc
     * @return Message|MessageInterface
     */
    public function compose($view = null, array $params = [])
    {
        return parent::compose($view, $params);
    }

    /**
     * @return \Swift_SpoolTransport|\Swift_Transport
     */
    public function getSpoolTransport()
    {
        if (!is_object($this->_spoolTransport)) {
            $config = [
                'class' => 'Swift_SpoolTransport',
                'constructArgs' => [
                    [
                        'class' => 'Swift_FileSpool',
                        'constructArgs' => [Yii::getAlias($this->spoolPath)],
                    ],
                ],
            ];
            $this->_spoolTransport = $this->createTransport($config);
        }

        return $this->_spoolTransport;
    }

    /**
     * @return \Swift_Mailer Swift mailer instance with Spool Transport.
     */
    public function getSwiftSpoolMailer()
    {
        if (!is_object($this->_swiftSpoolMailer)) {
            $this->_swiftSpoolMailer = $this->createSwiftSpoolMailer();
        }

        return $this->_swiftSpoolMailer;
    }

    /**
     * Creates Swift mailer instance with Spool Transport.
     * @return \Swift_Mailer mailer instance.
     */
    protected function createSwiftSpoolMailer()
    {
        return \Swift_Mailer::newInstance($this->getSpoolTransport());
    }

    /**
     * Add the given email message to queue.
     * This method will log a message about the email being queued.
     * @param Message $message email message instance to be queued
     * @return bool whether the message has been sent successfully
     */
    public function queue($message)
    {
        if (!$this->beforeQueue($message)) {
            return false;
        }

        Yii::info('Adding email "' . $message->getSubject() . '" to queue', __METHOD__);

        $isSuccessful = $this->getSwiftSpoolMailer()->send($message->getSwiftMessage()) > 0;
        $this->afterQueue($message, $isSuccessful);

        return $isSuccessful;
    }

    /**
     * This method is invoked right before mail being queued.
     * You may override this method to do last-minute preparation for the message.
     * If you override this method, please make sure you call the parent implementation first.
     * @param Message $message
     * @return bool whether to continue queuing an email.
     */
    public function beforeQueue($message)
    {
        $event = new MailEvent(['message' => $message]);
        $this->trigger(self::EVENT_BEFORE_QUEUE, $event);

        return $event->isValid;
    }

    /**
     * This method is invoked right after mail was added to queue.
     * You may override this method to do some postprocessing.
     * If you override this method, please make sure you call the parent implementation first.
     * @param Message $message
     * @param bool $isSuccessful
     */
    public function afterQueue($message, $isSuccessful)
    {
        $event = new MailEvent(['message' => $message, 'isSuccessful' => $isSuccessful]);
        $this->trigger(self::EVENT_AFTER_QUEUE, $event);
    }
}
