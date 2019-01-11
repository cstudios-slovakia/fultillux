<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project`.
 */
class m180801_081000_create_chat_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
     public function safeUp()
     {
         $this->createTable('chat_group', [
             'id' => $this->primaryKey(),
             'name' => $this->string(),
             'status' => $this->integer(),
             'last_message_id' => $this->integer(),
             'last_notification_at' => $this->datetime(),
             'created_at' =>$this->dateTime(),
             'updated_at' =>$this->dateTime(),
         ]);

     }

    /**
     * {@inheritdoc}
     */
     public function safeDown()
     {
         $this->dropTable('chat_group');
     }
}
