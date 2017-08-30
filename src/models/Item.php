<?php

namespace zacksleo\yii2\shop\models;

use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\CartPositionTrait;

class Item extends \zacksleo\yii2\cms\models\Item implements CartPositionInterface
{
    use CartPositionTrait;

    public function getPrice()
    {
        return $this->price;
    }

    public function getId()
    {
        return $this->id;
    }
}
