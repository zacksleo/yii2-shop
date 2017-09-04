<?php

namespace tests\models;

use tests\TestCase;
use zacksleo\yii2\shop\models\ShippingAddress;

class ShippingAddressTest extends TestCase
{
    public function testRules()
    {
        $model = new ShippingAddress();
        $this->assertTrue($model->isAttributeRequired('user_id'));
        $this->assertTrue($model->isAttributeRequired('phone'));
        $this->assertTrue($model->isAttributeRequired('name'));
        $this->assertTrue($model->isAttributeRequired('street'));
        $this->assertTrue($model->isAttributeRequired('district'));
        $this->assertTrue($model->isAttributeRequired('city'));
        $this->assertTrue($model->isAttributeRequired('province'));
    }

    public function testSave()
    {
        $model = new ShippingAddress();
        $model->user_id = 1;
        $model->status = 1;
        $model->phone = '18888888888';
        $model->street = '物联网街';
        $model->district = '滨江区';
        $model->city = '杭州市';
        $model->province = '浙江省';
        $model->postcode = '271400';
        $model->country = '中国';
        $this->assertTrue($model->save());
        $this->assertSame('中国浙江省杭州市滨江区', $model->getAddress());
        $this->assertSame('中国浙江省杭州市滨江区物联网街', $model->getFullAddress());
    }

    public function testAttributeLabels()
    {
        $model = new ShippingAddress();
        $this->assertArrayHasKey('phone', $model->attributeLabels());
        $this->assertArrayHasKey('city', $model->attributeLabels());
        $this->assertArrayHasKey('status', $model->attributeLabels());
    }
}
