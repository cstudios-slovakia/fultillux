<?php

use yii\db\Migration;

/**
 * Handles adding project_id to table `chat_group`.
 */
class m181008_135645_add_project_id_column_to_chat_group_table extends Migration
{

    public function safeUp()
    {
       $this->addColumn('chat_group', 'project_id', $this->integer());
    }

    public function safeDown()
    {
       $this->dropColumn('chat_group', 'project_id');
    }

}
