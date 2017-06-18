<?php

use yii\db\Migration;

/**
 * Handles the creation of table `check`.
 */
class m170618_083820_create_check_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('check', [
            'id' => $this->primaryKey(),
            'doc' => $this->text()->notNull(),
            'body' => $this->text()->notNull(),
            'created' => $this->integer(11)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('check');
    }
}
