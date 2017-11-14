<?php

namespace zacksleo\yii2\shop\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%order_payment_record}}".
 *
 * @property integer $id
 * @property string $order_sn
 * @property string $trace_no
 * @property string $amount
 * @property integer $created_at
 * @property integer $updated_at
 */
class OrderPaymentRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_payment_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_sn'], 'required'],
            [['amount'], 'number'],
            [['created_at', 'updated_at'], 'integer'],
            [['order_sn', 'trace_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_sn' => '订单编号',
            'trace_no' => '交易号',
            'amount' => '总金额',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className()
            ]
        ];
    }
}
