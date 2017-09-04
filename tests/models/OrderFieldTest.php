<?php

namespace tests\models;

use tests\data\models\ProductOrder;
use tests\TestCase;
use zacksleo\yii2\shop\models\OrderField;

class OrderFieldTest extends TestCase
{
    public function testSave()
    {
        $model = new ProductOrder();
        $model->order_id = 1;
        $model->items = [23, 99, 40];
        $this->assertTrue($model->save());
    }

    public function testFind()
    {
        $model = ProductOrder::findOne(1);
        $this->assertArrayHasKey('items', $model->toArray());
    }

    public function testDelete()
    {
        $model = ProductOrder::findOne(1);
        $this->assertTrue($model->delete());
    }

    public function testAttributeLabels()
    {
        $model = new OrderField();
        $this->assertArrayHasKey('value', $model->attributeLabels());
        $this->assertArrayHasKey('order_id', $model->attributeLabels());
    }

    public function testGetTypes()
    {
        $model = new OrderField();
        $this->assertArrayHasKey('string', $model->getTypes());
        $this->assertArrayHasKey('integer', $model->getTypes());
        $this->assertArrayHasKey('object', $model->getTypes());
    }
}
