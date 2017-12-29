<?php

namespace tests;

use yii;
use yii\helpers\ArrayHelper;
use yii\web\AssetManager;
use yii\web\View;

/**
 * This is the base class for all  unit tests.
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    public static $params;

    /**
     * Mock application prior running tests.
     */
    protected function setUp()
    {
        $this->mockWebApplication(
            [
                'components' => [
                    'request' => [
                        'class' => 'yii\web\Request',
                        'url' => '/test',
                        'enableCsrfValidation' => false,
                    ],
                    'response' => [
                        'class' => 'yii\web\Response',
                    ],
                ],
            ]
        );
        $this->setupTestDbData();
    }

    /**
     * Clean up after test.
     * By default the application created with [[mockApplication]] will be destroyed.
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->destroyApplication();
    }

    protected function mockApplication($config = [], $appClass = '\yii\console\Application')
    {
        new $appClass(
            ArrayHelper::merge(
                [
                    'id' => 'testapp',
                    'basePath' => __DIR__,
                    'vendorPath' => $this->getVendorPath(),
                ],
                $config
            )
        );
    }

    protected function mockWebApplication($config = [], $appClass = '\yii\web\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
            'aliases' => [
                '@bower' => '@vendor/bower-asset',
                '@npm' => '@vendor/npm-asset',
            ],
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'sqlite::memory:',
                ],
                'request' => [
                    'cookieValidationKey' => 'wefJDF8sfdsfSDefwqdxj9oq',
                    'scriptFile' => __DIR__ . '/index.php',
                    'scriptUrl' => '/index.php',
                ],
                'assetManager' => [
                    'basePath' => '@tests/assets',
                    'baseUrl' => '/',
                ]
            ]
        ], $config));
    }

    protected function getVendorPath()
    {
        return dirname(__DIR__) . '/vendor';
    }

    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        \Yii::$app = null;
    }

    /**
     * Setup tables for test ActiveRecord
     */
    protected function setupTestDbData()
    {
        $db = Yii::$app->getDb();
        // Structure :
        $db->createCommand()->createTable('item', [
            'id' => 'pk',
            'item_name' => 'string(125) not null',
            'subtitle' => 'string(125) not null',
            'categories' => 'string not null',
            'market_price' => 'decimal(10,2) not null default 0',
            'price' => 'integer not null default 0',
            'description' => 'text not null',
            'logo_image' => 'string not null',
            'status' => 'boolean not null default 1',
            'created_at' => 'integer not null',
            'updated_at' => 'integer not null',
        ])->execute();
        $db->createCommand()->createTable('order', [
            'id' => 'pk',
            'name' => 'string',
            'user_id' => 'integer not null',
            'recipient' => 'string',
            'phone' => 'string',
            'payment_method' => 'smallint',
            'total_amount' => 'decimal(10,2)',
            'status' => 'smallint',
            'sn' => 'string',
            'created_at' => 'integer',
            'updated_at' => 'integer',
            'address' => 'string',
            'remark' => 'string',
            'express' => 'string',
            'tracking_no' => 'string',
        ])->execute();
        $db->createCommand()->createTable('order_field', [
            'id' => 'pk',
            'order_id' => 'integer not null',
            'type' => 'string',
            'key' => 'string not null',
            'value' => 'text'
        ])->execute();
        $db->createCommand()->createTable('shipping_address', [
            'id' => 'pk',
            'user_id' => 'integer not null',
            'phone' => 'string not null',
            'name' => 'string not null',
            'street' => 'string not null',
            'postcode' => 'string(10)',
            'district' => 'string not null',
            'city' => 'string not null',
            'province' => 'string not null',
            'country' => 'string',
            'status' => 'boolean default 0 not null'
        ])->execute();
        $db->createCommand()->createTable('order_payment_record', [
            'id' => 'pk',
            'order_sn' => 'string not null',
            'trace_no' => 'string',
            'amount' => 'decimal(10,2)',
            'created_at' => 'integer',
            'updated_at' => 'integer'
        ])->execute();
    }

    /**
     * Creates a view for testing purposes
     *
     * @return View
     */
    protected function getView()
    {
        $view = new View();
        $view->setAssetManager(new AssetManager([
            'basePath' => '@tests/data/assets',
            'baseUrl' => '/',
        ]));
        return $view;
    }

    /**
     * Asserting two strings equality ignoring line endings
     *
     * @param string $expected
     * @param string $actual
     */
    public function assertEqualsWithoutLE($expected, $actual)
    {
        $expected = str_replace("\r\n", "\n", $expected);
        $actual = str_replace("\r\n", "\n", $actual);
        $this->assertEquals($expected, $actual);
    }
}
