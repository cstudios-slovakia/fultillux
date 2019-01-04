<?php

namespace app\widgets;

use app\assets\NoticerAsset;

use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

class Noticer extends Widget
{

    public $message;
    public $strong;

    private $_category;
    private $_size;

    public const CATEGORY_DESIGNSHIP = 'notice-designship';
    public const CATEGORY_SUCCESS = 'notice-success';
    public const CATEGORY_WARNING = 'notice-warning';
    public const CATEGORY_DANGER = 'notice-danger';
    public const CATEGORY_INFO = 'notice-info';

    public const SIZE_LARGE = 'notice-lg';
    public const SIZE_SMALL = 'notice-sm';

    public static function getCategories(){
        return [
            self::CATEGORY_DESIGNSHIP,
            self::CATEGORY_SUCCESS,
            self::CATEGORY_WARNING,
            self::CATEGORY_DANGER,
            self::CATEGORY_INFO,
        ];
    }

    public static function getSizes(){
        return [
            self::SIZE_LARGE,
            self::SIZE_SMALL,
        ];
    }

    public function setCategory($value){
        if (in_array($value, $this->categories)) {
            $this->_category = $value;
        }else{
            throw new InvalidConfigException('Invalid category: '.$value);
        }
    }

    public function setSize($value){
        if (in_array($value, $this->sizes)) {
            $this->_size = $value;
        }else{
            throw new InvalidConfigException('Invalid size: '.$value);
        }
    }

    public function init()
    {
        NoticerAsset::register($this->getView());
        parent::init();
    }

    public function run()
    {
        return
        Html::beginTag('div',['class'=>['notice',$this->_category]]).
        (isset($this->strong)?Html::tag('strong',$this->strong):'').' '.
        $this->message.
        Html::endTag('div');
    }

}
