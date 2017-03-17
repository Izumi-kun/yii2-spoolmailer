<?php

namespace izumi\spoolmailer;

use yii\console\Controller;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

/**
 * MailController
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class MailController extends Controller
{
    public $defaultAction = 'flush';
    /**
     * @var string|Mailer
     */
    public $mailer = 'mailer';
    /**
     * @var int The time limit (in seconds) per flush.
     */
    public $timeLimit = 30;

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $this->mailer = Instance::ensure($this->mailer, Mailer::className());

        return true;
    }

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        $options = [
            'flush' => ['timeLimit'],
        ];
        return array_merge(parent::options($actionID), ArrayHelper::getValue($options, $actionID, []));
    }

    /**
     * @inheritdoc
     */
    public function optionAliases()
    {
        return array_merge(parent::optionAliases(), [
            't' => 'timeLimit',
        ]);
    }

    /**
     * Sends messages.
     * @param int $limit The maximum number of messages to send per flush.
     */
    public function actionFlush($limit = 0)
    {
        $spool = $this->getSpool();
        $spool->setMessageLimit($limit);
        $spool->setTimeLimit($this->timeLimit);
        $transport = new MailerTransport($this->mailer);
        $spool->flushQueue($transport);
    }

    /**
     * Execute a recovery if for any reason a process is sending for too long.
     * @param int $timeout In second. Defaults is for very slow smtp responses.
     */
    public function actionRecover($timeout = 900)
    {
        $this->getSpool()->recover($timeout);
    }

    /**
     * @return \Swift_FileSpool|\Swift_Spool
     */
    protected function getSpool()
    {
        return $this->mailer->spoolTransport->getSpool();
    }
}
