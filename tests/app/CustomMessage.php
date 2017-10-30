<?php
/**
 * @link https://github.com/Izumi-kun/yii2-spoolmailer
 * @copyright Copyright (c) 2017 Viktor Khokhryakov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace tests\app;

use Swift_DependencyContainer;
use Swift_Mime_SimpleMessage;

class CustomMessage extends Swift_Mime_SimpleMessage
{
    public function __construct() {
        $args = Swift_DependencyContainer::getInstance()->createDependenciesFor('mime.message');
        parent::__construct(...$args);
    }
}
