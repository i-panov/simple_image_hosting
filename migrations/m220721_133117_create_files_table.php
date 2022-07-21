<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%files}}`.
 */
class m220721_133117_create_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%files}}', [
            'name' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('files_name_pk', '{{%files}}', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%files}}');
    }
}
