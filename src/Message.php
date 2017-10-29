<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace izumi\spoolmailer;

use Yii;
use yii\base\InvalidConfigException;

/**
 * Extends `yii\swiftmailer\Message` to enable queuing.
 *
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class Message extends \yii\swiftmailer\Message
{
    /**
     * @var Mailer the mailer instance that created this message.
     */
    public $mailer;

    /**
     * Enqueue this email message.
     * @param Mailer $mailer the mailer that should be used to queue this message.
     * If no mailer is given it will first check if "mailer" property is set and if not,
     * the "mail" application component will be used instead.
     * @return bool whether this message is added to queue successfully.
     * @throws InvalidConfigException
     */
    public function queue(Mailer $mailer = null)
    {
        if ($mailer === null && $this->mailer === null) {
            $mailer = Yii::$app->getMailer();
        } elseif ($mailer === null) {
            $mailer = $this->mailer;
        }
        if (!$mailer instanceof Mailer) {
            throw new InvalidConfigException('The mailer should be an instance of "\izumi\spoolmailer\Mailer".');
        }
        return $mailer->queue($this);
    }
}
