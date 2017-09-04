<?php

namespace zacksleo\yii2\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $payment_method
 * @property string $total_amount
 * @property integer $status
 * @property string $sn
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $address
 * @property string $remark
 */
class Order extends \yii\db\ActiveRecord
{
    const PAYMENT_METHOD_ALIPAY = 1;
    const PAYMENT_METHOD_WECHATPAY = 2;
    const STATUS_DELETED = -2; //已删除
    const STATUS_CANCELED = -1; //已取消
    const STATUS_UNPAID = 0; //未支付
    const STATUS_PAID = 1; //已支付
    const STATUS_CONSUMED = 2; //已消费

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'payment_method', 'status', 'created_at', 'updated_at'], 'integer'],
            [['total_amount'], 'number'],
            [['sn', 'address', 'remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户',
            'payment_method' => '支付方式',
            'total_amount' => '总金额',
            'status' => '状态',
            'sn' => '订单编号',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'address' => '配送地址',
            'remark' => '备注',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->sn = $this->createSN();
        }
        return parent::beforeSave($insert);
    }

    /**
     * 产生序列号
     * @param string $prefix 序列号前缀
     * @return string
     * @link http://goo.gl/TZYwZo 参考说明
     */
    public function createSN($prefix = '')
    {
        return $prefix . date('Y') . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
    }

    public function getStatusList()
    {
        return [
            self::STATUS_DELETED => '已删除',
            self::STATUS_CANCELED => '已取消',
            self::STATUS_UNPAID => '未支付',
            self::STATUS_PAID => '未解读',
            self::STATUS_CONSUMED => '已解读',
        ];
    }
}
