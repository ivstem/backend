<?php

use yii\db\Migration;

/**
 * Handles the creation of table `theses`.
 */
class m170618_082810_create_theses_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('theses', [
            'id' => $this->primaryKey(),
            'npp' => $this->string(50)->notNull(),
            'subject' => $this->string(255)->notNull(),
            'group' => $this->string(50)->notNull(),
            'author' => $this->string(255)->notNull(),
            'curator' => $this->string(255)->notNull(),
            'doc' => $this->text()->notNull(),
            'body' => $this->text()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('theses');
    }
}
