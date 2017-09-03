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
 */
class ShippingAddress extends \yii\db\ActiveRecord
{
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
            'phone' => '电话',
            'name' => '姓名',
            'street' => '街道',
            'postcode' => '邮编',
            'district' => '区',
            'city' => '市',
            'province' => '省',
            'country' => '国家',
        ];
    }
}
