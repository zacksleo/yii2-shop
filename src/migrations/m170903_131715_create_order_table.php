<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m170903_131715_create_order_table extends Migration
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
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('名称'),
            'user_id' => $this->integer()->notNull()->comment('用户'),
            'recipient' => $this->string()->comment('收件人'),
            'phone' => $this->string()->comment('电话'),
            'payment_method' => $this->smallInteger()->comment('支付方式'),
            'total_amount' => $this->decimal(10, 2)->comment('总金额'),
            'status' => $this->smallInteger()->comment('状态'),
            'sn' => $this->string()->comment('订单编号'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
            'address' => $this->string()->comment('配送地址'),
            'express' => $this->string()->comment('快递公司'),
            'tracking_no' => $this->string()->comment('物流编号'),
            'remark' => $this->string()->comment('备注'),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%order}}');
    }
}
