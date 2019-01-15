<?php

namespace app\modules\chat\widgets;

use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

class Chatbox extends Widget
{

    public $message;

    public function getViewPath()
    {
        return Yii::getAlias('@app/modules/chat/widgets/views');
    }

    public function run()
    {
      return $this->render('chatbox');
    }

}
