<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shipping_address`.
 */
class m170903_063331_create_shipping_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%shipping_address}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('用户'),
            'phone' => $this->string()->notNull()->comment('电话'),
            'name' => $this->string()->notNull()->comment('姓名'),
            'street' => $this->string()->notNull()->comment('街道'),
            'postcode' => $this->string(10)->comment('邮编'),
            'district' => $this->string()->notNull()->comment('区'),
            'city' => $this->string()->notNull()->comment('市'),
            'province' => $this->string()->notNull()->comment('省'),
            'country' => $this->string()->comment('国家'),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%shipping_address}}');
    }
}
