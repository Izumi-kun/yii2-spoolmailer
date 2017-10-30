<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace tests;

use izumi\spoolmailer\Mailer;
use Symfony\Component\Process\Process;
use Yii;
use yii\mail\MailerInterface;
use yii\mail\MessageInterface;
use yii\queue\file\Queue;
use yii\swiftmailer\Message;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @return Mailer|MailerInterface
     */
    public function getMailer()
    {
        return Yii::$app->getMailer();
    }

    /**
     * @return Queue|object
     */
    public function getFileQueue()
    {
        return Yii::$app->get('fileQueue');
    }

    /**
     * @param MessageInterface $message
     * @return bool|string
     */
    public function getMessageFilePath(MessageInterface $message)
    {
        return Yii::getAlias($this->getMailer()->fileTransportPath . '/' . $message->getSubject());
    }

    public function assertMessageNotSent(MessageInterface $message)
    {
        $this->assertFileNotExists($this->getMessageFilePath($message));
    }

    public function assertMessageSent(MessageInterface $message)
    {
        $this->assertFileExists($this->getMessageFilePath($message));
    }

    /**
     * @return Message
     */
    public function createMessage()
    {
        $message = $this->getMailer()->compose();
        $message->setSubject(uniqid() . '.eml');
        $message->setFrom('from@domain.com');
        $message->setTo('to@domain.com');
        $class = static::class;
        $message->setTextBody("Hello from `{$class}`!");

        return $message;
    }

    /**
     * @return Message
     */
    public function createInvalidMessage()
    {
        $message = $this->createMessage();
        $message->setSubject('invalid');

        return $message;
    }

    public function runProcess($cmd)
    {
        $process = new Process(PHP_BINARY . " tests/yii {$cmd}");
        $status = $process->run();
        $this->assertEquals(0, $status);
    }
}
