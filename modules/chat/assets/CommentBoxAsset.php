<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\chat\assets;

use yii\web\AssetBundle;

class CommentBoxAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/chat/resources';
    public $css = [
        'css/commentbox.css',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
