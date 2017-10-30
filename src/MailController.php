<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace izumi\spoolmailer;

use yii\console\Controller;
use yii\di\Instance;

/**
 * MailController
 *
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class MailController extends Controller
{
    public $defaultAction = 'flush';
    /**
     * @var Mailer|array|string the mailer object or the application component ID of the mailer object.
     */
    public $mailer = 'mailer';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->mailer = Instance::ensure($this->mailer, Mailer::class);
    }

    /**
     * Sends messages.
     */
    public function actionFlush()
    {
        $this->mailer->flushQueue();
    }
}
