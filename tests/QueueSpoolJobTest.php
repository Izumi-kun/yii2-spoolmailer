<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace tests;

use izumi\spoolmailer\spools\QueueSpoolJob;
use tests\app\CustomMessage;
use yii\base\InvalidConfigException;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class QueueSpoolJobTest extends TestCase
{
    public function testIncorrectMessage()
    {
        $message = new CustomMessage();
        $this->expectException(InvalidConfigException::class);
        new QueueSpoolJob(['message' => $message]);
    }

    public function testExecute()
    {
        $message = $this->createMessage();
        $job = new QueueSpoolJob(['message' => $message->getSwiftMessage()]);
        $job->execute($this->getFileQueue());
        $this->assertMessageSent($message);
    }
}
