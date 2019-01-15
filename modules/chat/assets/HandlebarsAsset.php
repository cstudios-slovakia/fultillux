<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\chat\assets;

use yii\web\AssetBundle;

class HandlebarsAsset extends AssetBundle
{

    public $sourcePath = '@bower/handlebars';
    public $js = [
        'handlebars.min.js',
    ];

}
