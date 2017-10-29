<?php

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
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $this->mailer = Instance::ensure($this->mailer, Mailer::class);

        return true;
    }

    /**
     * Sends messages.
     */
    public function actionFlush()
    {
        $this->mailer->flushQueue();
    }
}
