<?php

namespace app\modules\chat\widgets;

use Yii;
use DateTime;

use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\db\Expression;

use app\modules\chat\models\Message;
use app\models\User;

class Comment extends Widget
{

    public $messageId;
    public $message;

    private $_user;
    private $_message;

    public function getViewPath()
    {
        return Yii::getAlias('@app/modules/chat/widgets/views');
    }

    public function init(){

        parent::init();
        if (isset($this->message)) {
          $this->_message = $this->message;
        }else{
          $this->_message = Message::findOne($this->messageId);
        }
        $this->_user = $this->_message->user;

    }

    public function run()
    {
      $expression = new \yii\db\Expression('NOW()');
      $now = (new \yii\db\Query)->select($expression)->scalar();  // SELECT NOW();

      return $this->render('_comment',[
        'avatarUrl' => $this->_user->avatar,
        'username' => $this->_user->username,
        'message' => $this->_message->content,
        'action' => 'commented',
        'when' => Yii::$app->formatter->asRelativeTime($this->_message->timestamp, $now),
      ]);
    }

}
