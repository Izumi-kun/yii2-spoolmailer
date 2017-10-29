<?php

namespace izumi\spoolmailer\spools;

use Swift_FileSpool;
use Swift_SpoolTransport;
use Yii;
use yii\helpers\FileHelper;
use yii\mail\BaseMailer;

/**
 * Stores Messages on the filesystem.
 *
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class FileSpool extends BaseSpool
{
    /**
     * @var string the spool directory
     */
    public $path = '@runtime/mail_spool';
    /**
     * @var int the permission to be set for newly created spool directory.
     */
    public $dirMode = 0777;
    /**
     * @var int the maximum number of messages to send per flush
     */
    public $messageLimit = 0;
    /**
     * @var int the time limit (in seconds) per flush.
     */
    public $timeLimit = 30;
    /**
     * @var int in second Defaults is for very slow smtp responses
     */
    public $recoverTimeout = 900;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->path = Yii::getAlias($this->path);
        if (!is_dir($this->path)) {
            FileHelper::createDirectory($this->path, $this->dirMode, true);
        }
        $this->setTransport([
            'class' => Swift_SpoolTransport::class,
            'constructArgs' => [
                [
                    'class' => Swift_FileSpool::class,
                    'constructArgs' => [$this->path],
                ],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function flush(BaseMailer $mailer, &$failedRecipients = null)
    {
        /** @var Swift_FileSpool $spool */
        $spool = $this->getTransport()->getSpool();
        $spool->setTimeLimit($this->timeLimit);
        $spool->setMessageLimit($this->messageLimit);

        $spool->recover($this->recoverTimeout);

        return parent::flush($mailer, $failedRecipients);
    }
}
