<?php

namespace tests;

use zacksleo\yii2\shop\models\Item;

class ItemTest extends TestCase
{
    public function testGetPrice()
    {
        $model = new Item();
        $model->price = 200;
        $this->assertSame(200, $model->getPrice());
    }

    public function testGetLabel()
    {
        $model = new Item();
        $model->item_name = 'item name';
        $this->assertSame('item name', $model->getLabel());
    }

    public function testGetUniqueId()
    {
        $model = new Item();
        $model->id = 1;
        $this->assertSame(1, $model->getUniqueId());
    }
}
