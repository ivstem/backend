<?php

use yii\db\Migration;

/**
 * Handles the creation of table `plagiat`.
 */
class m170618_083617_create_plagiat_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('plagiat', [
            'id' => $this->primaryKey(),
            'id1' => $this->integer(11)->notNull(),
            'id2' => $this->integer(11)->notNull(),
            'per1' => $this->float()->notNull(),
            'per2' => $this->float()->notNull(),
            'per3' => $this->float()->notNull(),
            'per4' => $this->float()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('plagiat');
    }
}
