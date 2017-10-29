<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace izumi\spoolmailer\spools;

use Swift_MemorySpool;
use Swift_SpoolTransport;

/**
 * Stores Messages in memory.
 *
 * @author Viktor Khokhryakov <viktor.khokhryakov@gmail.com>
 */
class MemorySpool extends BaseSpool
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setTransport([
            'class' => Swift_SpoolTransport::class,
            'constructArgs' => [
                [
                    'class' => Swift_MemorySpool::class,
                    'constructArgs' => [],
                ],
            ],
        ]);
    }
}
