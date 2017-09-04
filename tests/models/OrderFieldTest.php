<?php

namespace tests\models;

use tests\data\models\ProductOrder;
use tests\TestCase;

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
        $this->assertArrayHasKey('order_id', $model->toArray());
    }

    public function testDelete()
    {
        $model = ProductOrder::findOne(1);
        $this->assertTrue($model->delete());
    }
}
