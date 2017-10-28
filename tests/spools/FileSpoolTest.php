<?php

namespace tests\spools;

use izumi\spoolmailer\spools\FileSpool;
use Yii;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class FileSpoolTest extends TestCase
{
    /**
     * @return FileSpool|object
     */
    public function getSpool()
    {
        return Yii::$app->get('fileSpool');
    }
}
