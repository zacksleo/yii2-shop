<?php

namespace tests\models;

use tests\TestCase;
use zacksleo\yii2\shop\models\Order;

class OrderTest extends TestCase
{
    public function testRules()
    {
        $model = new Order();
        $this->assertTrue($model->isAttributeRequired('user_id'));
        $model->user_id = 1;
        $model->status = Order::STATUS_DELETED;
        $model->total_amount = 10;
        $model->remark = 'remark';
        $model->payment_method = Order::PAYMENT_METHOD_ALIPAY;
        $model->address = 'address';
        $model->recipient = 'recipient';
        $model->phone = '18888888888';
        $this->assertTrue($model->save());
    }

    public function testAttributeLabels()
    {
        $model = new Order();
        $this->assertArrayHasKey('remark', $model->attributeLabels());
        $this->assertArrayHasKey('payment_method', $model->attributeLabels());
    }

    public function testGetStatusList()
    {
        $this->assertArrayHasKey('-2', Order::getStatusList());
        $this->assertArrayHasKey('2', Order::getStatusList());
    }

    public function testGetPaymentMethodList()
    {
        $this->assertArrayHasKey('1', Order::getPaymentMethodList());
        $this->assertArrayHasKey('2', Order::getPaymentMethodList());
    }
}
