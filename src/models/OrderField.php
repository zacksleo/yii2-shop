<?php

namespace zacksleo\yii2\shop\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\base\DynamicModel;
use yii\base\InvalidParamException;

/**
 * This is the model class for table "{{%order_field}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property string $type
 * @property string $key
 * @property string $value
 */
class OrderField extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_field}}';
    }

    /**
     * @param bool $forDropDown if false - return array or validators, true - key=>value for dropDown
     * @return array
     */
    public function getTypes($forDropDown = true)
    {
        $values = [
            'string' => ['value', 'string'],
            'integer' => ['value', 'integer'],
            'boolean' => ['value', 'boolean', 'trueValue' => "1", 'falseValue' => "0", 'strict' => true],
            'float' => ['value', 'number'],
            'email' => ['value', 'email'],
            'ip' => ['value', 'ip'],
            'url' => ['value', 'url'],
            'object' => [
                'value',
                function ($attribute, $params) {
                    $object = null;
                    try {
                        Json::decode($this->$attribute);
                    } catch (InvalidParamException $e) {
                        $this->addError($attribute, "$attribute must be a valid JSON object");
                    }
                }
            ],
        ];

        if (!$forDropDown) {
            return $values;
        }

        $return = [];
        foreach ($values as $key => $value) {
            $return[$key] = $key;
        }

        return $return;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['order_id', 'integer'],
            [['value'], 'string'],
            ['key', 'string', 'max' => 255],
            [
                ['key'],
                'unique',
                'targetAttribute' => ['order_id', 'key'],
                'message' => '{attribute} "{value}" already exists for this section.'
            ],
            ['type', 'in', 'range' => array_keys($this->getTypes(false))],
            ['type', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'type' => 'Type',
            'order_id' => 'order_id',
            'key' => 'Key',
            'value' => 'Value',
        ];
    }

    public function beforeSave($insert)
    {
        $validators = $this->getTypes(false);
        if (!array_key_exists($this->type, $validators)) {
            $this->addError('type', 'Please select correct type');
            return false;
        }

        $model = DynamicModel::validateData([
            'value' => $this->value
        ], [
            $validators[$this->type],
        ]);

        if ($model->hasErrors()) {
            $this->addError('value', $model->getFirstError('value'));
            return false;
        }

        if ($this->hasErrors()) {
            return false;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function getSettings()
    {
        $settings = static::find()->asArray()->all();
        return array_merge_recursive(
            ArrayHelper::map($settings, 'key', 'value', 'order_id'),
            ArrayHelper::map($settings, 'key', 'type', 'order_id')
        );
    }

    /**
     * @inheritdoc
     */
    public function setSetting($order_id, $key, $value, $type = null)
    {
        $model = static::findOne(['order_id' => $order_id, 'key' => $key]);

        if ($model === null) {
            $model = new static();
        }
        $model->order_id = $order_id;
        $model->key = $key;
        $model->value = strval($value);

        if ($type !== null) {
            $model->type = $type;
        } else {
            $t = gettype($value);
            if ($t == 'string') {
                $error = false;
                try {
                    Json::decode($value);
                } catch (InvalidParamException $e) {
                    $error = true;
                }
                if (!$error) {
                    $t = 'object';
                }
            }
            $model->type = $t;
        }

        return $model->save();
    }

    /**
     * @inheritdoc
     */
    public function deleteSetting($order_id, $key)
    {
        $model = static::findOne(['order_id' => $order_id, 'key' => $key]);

        if ($model) {
            return $model->delete();
        }
        return true;
    }

    /**
     * @param $key
     * @param $order_id
     * @return array|null|ActiveRecord
     */
    public function findSetting($key, $order_id)
    {
        return $this->find()->where(['order_id' => $order_id, 'key' => $key])->limit(1)->one();
    }
}
