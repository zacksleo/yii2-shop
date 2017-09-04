<?php

namespace tests\data\models;

use yii\base\Model;
use yii\helpers\Url;
use zacksleo\yii2\shop\models\OrderField;

class ProductOrder extends Model
{
    public $order_id;
    public $items;

    public function rules()
    {
        return [
            [['item_id', 'sales', 'freight'], 'required'],
            [['items'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'items' => '内容',
        ];
    }

    public function fields()
    {
        return [
            'items',
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $model = new OrderField();
        if ($model->setSetting($this->order_id, 'items', serialize($this->items), 'array')) {
            return true;
        } else {
            $this->addErrors($model->getErrors());
            return false;
        }
    }

    public function delete()
    {
        $model = new OrderField();
        foreach ($this->fields() as $key) {
            $model->deleteSetting($this->order_id, $key);
        }
        return true;
    }

    public static function findOne($id)
    {
        $fields = OrderField::findAll(['order_id' => $id]);
        $productOrder = new ProductOrder();
        foreach ($fields as $field) {
            if ($productOrder->hasProperty($field->key)) {
                $productOrder->{$field->key} = $field->value;
            }
        }
        $productOrder->order_id = $id;
        return $productOrder;
    }

    public function getUrl()
    {
        return Url::to(['order/detail', 'id' => $this->order_id]);
    }
}
