<?php

namespace zacksleo\yii2\shop\models;

use Yii;

/**
 * This is the model class for table "mops_shipping_address".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $phone
 * @property string $name
 * @property string $street
 * @property string $postcode
 * @property string $district
 * @property string $city
 * @property string $province
 * @property string $country
 * @property boolean $status
 */
class ShippingAddress extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shipping_address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'phone', 'name', 'street', 'district', 'city', 'province'], 'required'],
            [['user_id'], 'integer'],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            [['phone', 'name', 'street', 'district', 'city', 'province', 'country'], 'string', 'max' => 255],
            [['postcode'], 'string', 'max' => 10],
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
            'phone' => '手机号码',
            'name' => '姓名',
            'street' => '街道',
            'postcode' => '邮编',
            'district' => '区',
            'city' => '市',
            'province' => '省',
            'country' => '国家',
            'status' => '状态',
        ];
    }

    /**
     * @param string $glue
     * @return string
     */
    public function getAddress($glue = '')
    {
        return implode($glue, [$this->country, $this->province, $this->city, $this->district]);
    }

    /**
     * @param string $glue
     * @return string
     */
    public function getFullAddress($glue = '')
    {
        return implode($glue, [$this->country, $this->province, $this->city, $this->district, $this->street]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($this->status == self::STATUS_ACTIVE) {
            self::updateAll(['status' => 0], [
                'and',
                ['user_id' => $this->user_id],
                [' <> ', 'id', $this->id]
            ]);
        }
    }
}
