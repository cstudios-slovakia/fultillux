<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\chat\assets;

use yii\web\AssetBundle;

class ListjsAsset extends AssetBundle
{

    public $sourcePath = '@bower/listjs/dist';
    public $js = [
        'list.min.js',
    ];

}
