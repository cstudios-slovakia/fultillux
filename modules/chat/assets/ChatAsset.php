<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\chat\assets;

use yii\web\AssetBundle;

class ChatAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/chat/resources';
    public $css = [
        'css/chat.css',
        'https://fonts.googleapis.com/css?family=Lato:400,700',
    ];
    public $js = [
        'js/chat.js',
    ];
    public $depends = [
        'app\modules\chat\assets\MustacheAsset',
        'app\modules\chat\assets\HandlebarsAsset',
        'app\modules\chat\assets\ListjsAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
