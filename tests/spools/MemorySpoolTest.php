<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

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
