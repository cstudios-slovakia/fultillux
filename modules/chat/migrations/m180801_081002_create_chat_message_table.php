<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project`.
 */
class m180801_081002_create_chat_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
     public function safeUp()
     {
         $this->createTable('chat_message', [
             'id' => $this->primaryKey(),
             'user_id' => $this->integer()->notNull(),
             'chat_group_id' => $this->integer()->notNull(),
             'content' => $this->text(),
             'timestamp' => $this->datetime(),
         ]);

         $this->createIndex(
             'idx-chat-message-user-id',
             'chat_message',
             'user_id'
         );

         $this->createIndex(
             'idx-chat-message-chat-group-id',
             'chat_message',
             'chat_group_id'
         );

         $this->addForeignKey(
             'fk-chat-message-user-id',
             'chat_message',
             'user_id',
             'user',
             'id',
             'CASCADE'
         );

         $this->addForeignKey(
             'fk-chat-message-chat-group-id',
             'chat_message',
             'chat_group_id',
             'chat_group',
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
             'fk-chat-message-user-id',
             'chat_message'
         );

         $this->dropForeignKey(
             'fk-chat-message-chat-group-id',
             'chat_message'
         );

         $this->dropIndex(
             'idx-chat-message-user-id',
             'chat_message'
         );


         $this->dropIndex(
             'idx-chat-message-chat-group-id',
             'chat_message'
         );

         $this->dropTable('chat_message');
     }
}
