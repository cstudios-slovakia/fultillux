<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project`.
 */
class m180801_081001_create_chat_group_member_table extends Migration
{
    /**
     * {@inheritdoc}
     */
     public function safeUp()
     {
         $this->createTable('chat_group_member', [
             'id' => $this->primaryKey(),
             'user_id' => $this->integer(),
             'chat_group_id' => $this->integer(),
             'joined_at' =>$this->dateTime(),
         ]);

         $this->createIndex(
             'idx-chat-group-member-user-id',
             'chat_group_member',
             'user_id'
         );

         $this->createIndex(
             'idx-chat-group-member-chat-group-id',
             'chat_group_member',
             'chat_group_id'
         );

         $this->addForeignKey(
             'fk-chat-group-member-user-id',
             'chat_group_member',
             'user_id',
             'user',
             'id',
             'CASCADE'
         );

         $this->addForeignKey(
             'fk-chat-group-member-chat-group-id',
             'chat_group_member',
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
             'fk-chat-group-member-user-id',
             'chat_group_member'
         );

         $this->dropForeignKey(
             'fk-chat-group-member-chat-group-id',
             'chat_group_member'
         );

         $this->dropIndex(
             'idx-chat-group-member-user-id',
             'chat_group_member'
         );


         $this->dropIndex(
             'idx-chat-group-member-chat-group-id',
             'chat_group_member'
         );

         $this->dropTable('chat_group_member');
     }
}
