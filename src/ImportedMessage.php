<?php

namespace izumi\spoolmailer;

use Swift_Message;
use yii\base\NotSupportedException;

/**
 * Class allows creating `Message` from `Swift_Message` instance.
 *
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class ImportedMessage extends \yii\swiftmailer\Message
{
    /**
     * @var Swift_Message Swift message instance.
     */
    private $_swiftMessage;

    /**
     * @inheritdoc
     * @param Swift_Message $message
     */
    public function __construct(Swift_Message $message, array $config = [])
    {
        $this->_swiftMessage = $message;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function getSwiftMessage()
    {
        return $this->_swiftMessage;
    }

    /**
     * @inheritdoc
     */
    public function setSignature($signature)
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function addSignature($signature)
    {
        throw new NotSupportedException();
    }
}
