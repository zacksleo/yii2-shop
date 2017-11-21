<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_item`.
 */
class m170903_133706_create_order_field_table extends Migration
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
        $this->createTable('{{%order_field}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'type' => $this->string()->notNull(),
            'key' => $this->string()->notNull(),
            'value' => $this->text(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%order_field}}');
    }
}
