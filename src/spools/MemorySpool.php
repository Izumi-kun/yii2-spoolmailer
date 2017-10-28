<?php

namespace izumi\spoolmailer\spools;

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
            'class' => 'Swift_SpoolTransport',
            'constructArgs' => [
                [
                    'class' => 'Swift_MemorySpool',
                    'constructArgs' => [],
                ],
            ],
        ]);
    }
}
