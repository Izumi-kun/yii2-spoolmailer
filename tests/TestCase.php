<?php

namespace izumi\tests\spoolmailer;

use yii\helpers\ArrayHelper;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        parent::tearDown();
        \Yii::$app = null;
    }

    /**
     * Populates Yii::$app with a new application
     * The application will be destroyed on tearDown() automatically.
     * @param array $config The application configuration, if needed
     * @param string $appClass name of the application class to create
     */
    protected function mockApplication($config = [], $appClass = '\yii\console\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
        ], $config));
    }

}
