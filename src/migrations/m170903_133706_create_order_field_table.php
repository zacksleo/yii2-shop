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
        $this->createTable('{{%order_field}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'type' => $this->string()->notNull(),
            'key' => $this->string()->notNull(),
            'value' => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%order_item}}');
    }
}
