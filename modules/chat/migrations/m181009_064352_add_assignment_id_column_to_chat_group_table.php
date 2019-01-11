<?php

use yii\db\Migration;

/**
 * Handles adding assignment_id to table `chat_group`.
 */
class m181009_064352_add_assignment_id_column_to_chat_group_table extends Migration
{

    public function safeUp()
    {
       $this->addColumn('chat_group', 'assignment_id', $this->integer());
    }

    public function safeDown()
    {
       $this->dropColumn('chat_group', 'assignment_id');
    }

}
