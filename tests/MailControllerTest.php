<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace tests;

use Yii;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class MailControllerTest extends TestCase
{
    public function testFlush()
    {
        $message = $this->createMessage();
        $this->getMailer()->queue($message);

        $this->assertMessageNotSent($message);

        Yii::$app->runAction('mail/flush');

        $this->assertMessageSent($message);
    }
}
