<?php

namespace zacksleo\yii2\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property integer $payment_method
 * @property string $total_amount
 * @property integer $status
 * @property string $sn
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $address
 * @property string $remark
 * @property string $recipient
 * @property string $phone
 * @property string $express
 * @property string $tracking_no
 */
class Order extends \yii\db\ActiveRecord
{
    const PAYMENT_METHOD_ALIPAY = 1;
    const PAYMENT_METHOD_WECHATPAY = 2;
    const PAYMENT_METHOD_QRCODE = 3;

    const STATUS_RETURN_FAILED = -5; //退货失败
    const STATUS_RETURNED = -4;// 已退货
    const STATUS_RETURNING = -3; //退货中
    const STATUS_DELETED = -2; //已删除
    const STATUS_CANCELED = -1; //已取消
    const STATUS_UNPAID = 0; //未支付
    const STATUS_PAID = 1; //已支付
    const STATUS_UNSHIPPED = 2; //未发货
    const STATUS_SHIPPED = 3; //已发货
    const STATUS_DELIVERED = 4; //已签收
    const STATUS_CONSUMED = 5; //已消费

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
            [['user_id', 'name'], 'required'],
            [['user_id', 'payment_method', 'status', 'created_at', 'updated_at'], 'integer'],
            [['total_amount'], 'number'],
            [['sn', 'address', 'phone', 'recipient', 'remark', 'express', 'tracking_no', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'user_id' => '用户',
            'payment_method' => '支付方式',
            'total_amount' => '总金额',
            'status' => '状态',
            'sn' => '订单编号',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'address' => '配送地址',
            'remark' => '备注',
            'recipient' => '收件人',
            'phone' => '电话',
            'express' => '送货公司',
            'tracking_no' => '物流编号',
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

    public static function getStatusList()
    {
        return [
            self::STATUS_RETURN_FAILED => '退货失败',
            self::STATUS_RETURNED => '已退货',
            self::STATUS_RETURNING => '退货中',
            self::STATUS_DELETED => '已删除',
            self::STATUS_CANCELED => '已取消',
            self::STATUS_UNPAID => '未支付',
            self::STATUS_PAID => '已支付',
            self::STATUS_UNSHIPPED => '未发货',
            self::STATUS_SHIPPED => '已发货',
            self::STATUS_DELIVERED => '已签收',
            self::STATUS_CONSUMED => '已消费',
        ];
    }

    public static function getPaymentMethodList()
    {
        return [
            self::PAYMENT_METHOD_ALIPAY => '支付宝',
            self::PAYMENT_METHOD_WECHATPAY => '微信',
            self::PAYMENT_METHOD_QRCODE => '扫码转账',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderPaymentRecord()
    {
        return $this->hasOne(OrderPaymentRecord::className(), ['order_sn' => 'sn']);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        OrderField::deleteAll(['order_id' => $this->id]);
        OrderPaymentRecord::deleteAll(['order_sn' => $this->sn]);
    }
}
