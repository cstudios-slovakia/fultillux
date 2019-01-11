<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project`.
 */
class m180801_081003_add_foreign_key_to_chat_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
     public function safeUp()
     {
         $this->createIndex(
             'idx-chat-group-last-message-id',
             'chat_group',
             'last_message_id'
         );

         $this->addForeignKey(
             'fk-chat-group-last-message-id',
             'chat_group',
             'last_message_id',
             'chat_message',
             'id',
             'CASCADE'
         );
     }

    /**
     * {@inheritdoc}
     */
     public function safeDown()
     {

         $this->dropForeignKey(
             'fk-chat-group-last-message-id',
             'chat_group'
         );

         $this->dropIndex(
             'idx-chat-group-last-message-id',
             'chat_group'
         );

     }
}
