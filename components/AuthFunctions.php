<?php

namespace app\components;

use Yii;

class AuthFunctions
{

    public static function checkAccess()
    {
        $user = \Yii::$app->user->identity;

        if (method_exists($user, 'getIsAdmin')) {
            return $user->getIsAdmin();
        }

    }


}
