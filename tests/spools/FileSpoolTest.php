<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

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
