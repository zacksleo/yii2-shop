<?php

namespace tests\models;

use tests\TestCase;
use zacksleo\yii2\shop\models\OrderPaymentRecord;

class OrderPaymentRecordTest extends TestCase
{
    public function testRules()
    {
        $model = new OrderPaymentRecord();
        $this->assertTrue($model->isAttributeRequired('order_sn'));
        $model->order_sn = '2017111112120034558';
        $model->trace_no = 'trace_no';
        $model->amount = 300;
        $this->assertTrue($model->save());
    }

    public function testAttributeLabels()
    {
        $model = new OrderPaymentRecord();
        $this->assertArrayHasKey('order_sn', $model->attributeLabels());
        $this->assertArrayHasKey('trace_no', $model->attributeLabels());
    }
}
