<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace tests;

use izumi\spoolmailer\Message;
use yii\base\InvalidConfigException;
use yii\swiftmailer\Mailer;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class MessageTest extends TestCase
{
    public function testQueueWithWrongMailer()
    {
        $message = new Message(['mailer' => new Mailer()]);

        $this->expectException(InvalidConfigException::class);
        $message->queue();
    }
}
