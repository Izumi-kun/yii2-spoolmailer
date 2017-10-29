<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace izumi\spoolmailer\spools;

use izumi\spoolmailer\MailerTransport;
use Swift_SpoolTransport;
use yii\mail\BaseMailer;
use yii\swiftmailer\Mailer;

/**
 * BaseSpool.
 *
 * @method Swift_SpoolTransport getTransport()
 * @property Swift_SpoolTransport $transport
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
abstract class BaseSpool extends Mailer
{
    /**
     * Sends messages using the given mailer instance.
     * @param BaseMailer $mailer a mailer instance.
     * @param string[] $failedRecipients an array of failures by-reference.
     * @return int the number of sent emails.
     */
    public function flush(BaseMailer $mailer, &$failedRecipients = null)
    {
        $transport = new MailerTransport($mailer);
        return $this->getTransport()->getSpool()->flushQueue($transport, $failedRecipients);
    }
}
