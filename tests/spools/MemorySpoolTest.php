<?php

namespace tests\spools;

use izumi\spoolmailer\spools\MemorySpool;
use Yii;

/**
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class MemorySpoolTest extends TestCase
{
    /**
     * @return MemorySpool|object
     */
    public function getSpool()
    {
        return Yii::$app->get('memorySpool');
    }
}
