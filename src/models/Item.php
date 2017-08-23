<?php

namespace zacksleo\yii2\shop\models;

use yii2mod\cart\models\CartItemInterface;

class Item extends \zacksleo\yii2\cms\models\Item implements CartItemInterface
{
    public function getPrice()
    {
        return $this->price;
    }

    public function getLabel()
    {
        return $this->item_name;
    }

    public function getUniqueId()
    {
        return $this->id;
    }
}
