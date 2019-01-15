<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\chat\assets;

use yii\web\AssetBundle;

class MustacheAsset extends AssetBundle
{

    public $sourcePath = '@bower/mustache';
    public $js = [
        'mustache.min.js',
    ];

}
