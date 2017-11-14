<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_payment_record`.
 */
class m171114_094918_create_order_payment_record_table extends Migration
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
        $this->createTable('{{%order_payment_record}}', [
            'id' => $this->primaryKey(),
            'order_sn' => $this->string()->notNull()->comment('订单编号'),
            'trace_no' => $this->string()->comment('交易号'),
            'amount' => $this->decimal(10, 2)->comment('总金额'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%order_payment_record}}');
    }
}
