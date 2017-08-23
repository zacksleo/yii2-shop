<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m170823_030301_create_cart_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql' || $this->db->driverName === 'mariadb') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%cart}}', [
            'sessionId' => $this->string(),
            'cartData' => 'longtext',
            'PRIMARY KEY (`sessionId`)',
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%cart}}');
    }
}
