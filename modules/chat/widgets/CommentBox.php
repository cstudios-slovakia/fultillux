<?php

namespace app\modules\chat\widgets;

use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

use app\modules\chat\assets\CommentBoxAsset;
use app\modules\chat\models\Group;
use app\models\Project;

use thamtech\uuid\helpers\UuidHelper;

class CommentBox extends Widget
{

    public $label;
    public $placeholder;

    private $_uuid;
    private $_group;

    public function getViewPath()
    {
        return Yii::getAlias('@app/modules/chat/widgets/views');
    }

    public function init(){

        CommentBoxAsset::register($this->getView());

        parent::init();
        if(!isset($this->label)){
          $this->label = Yii::t('chat','Write a comment');
        }
        if(!isset($this->placeholder)){
          $this->placeholder = Yii::t('chat','Write your text here');
        }
        $this->_uuid = UuidHelper::uuid();

    }

    public function setGroupId($value){
        $this->_group = Group::findOne($value);
    }

    public function setGroup($value){
        $this->_group = $value;
    }

    public function getGroup(){
        return $this->_group;
    }

    public function getUuid(){
        return $this->_uuid;
    }

    public function run()
    {
      return $this->render('_commentbox',[
        'label' => $this->label,
        'uuid' => $this->uuid,
        'group' => $this->group,
        'placeholder' => $this->placeholder,
        'commentboxId' => 'commentbox_'.$this->uuid,
        'commentboxButtonId' => 'commentboxButton_'.$this->uuid,
      ]);
    }

}
