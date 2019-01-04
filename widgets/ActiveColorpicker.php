<?php

namespace app\widgets;

use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

class ActiveColorpicker extends Widget
{
    public $containerConfig;

    public $config;

    public $model;

    public $attribute;

    public function init()
    {

      if($this->containerConfig === null){
        $this->containerConfig = [
          'class'=>['input-group','colorpicker-component'],
        ];
      }

      if($this->config === null){
        $this->config =[
          'value' => '#000000',
          'class' => ['form-control'],
        ];
      }else{
        if(!array_key_exists('value', $this->config)) $this->config['value'] = '#000000';
        if(!array_key_exists('class', $this->config)) $this->config['class'] = ['form-control'];
      }

      if($this->model === null){
        throw new InvalidConfigException('You did not set up model for this widget');
      }

      if($this->attribute === null){
        throw new InvalidConfigException('You did not set up attribute for this widget.');
      }

    }

    public function run()
    {
        return
        Html::beginTag('div',$this->containerConfig).
        Html::activeInput('text', $this->model, $this->attribute, $this->config).
        Html::tag('span', Html::tag('i'), ['class'=>['input-group-addon']]).
        Html::endTag('div');
    }

    public static function getScript($selector = '.input-group.colorpicker-component', $color = '#000000', $format = 'rgb'){
        return "$('".$selector."').each(function(index){".
          // "console.log($(this).children(':input')[0].value);".
          // "console.log(index);".
          "$(this).colorpicker({color: $(this).children(':input')[0].value, format: '".$format."'});".
        "})";
        // return "$('".$selector."').colorpicker({ color: '".$color."', format: '".$format."' });";
    }
}
