<?php

namespace app\controllers\user;

use Yii;

use dektrium\user\models\Profile;
use dektrium\user\controllers\SettingsController as BaseSettingsController;

class SettingsController extends BaseSettingsController
{

    public $request;
    public $enableCsrfValidation = false;

    // public function actionEdit(){
    // }

    // public function actionProfile(){
    // }
}
