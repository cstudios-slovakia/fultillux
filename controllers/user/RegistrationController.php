<?php

namespace app\controllers\user;

use Yii;

use app\models\user\RegistrationForm;

use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;



class RegistrationController extends BaseRegistrationController
{
    // public function actionLogin(){
    //   return null;
    // }
    use AjaxValidationTrait;
    use EventTrait;

    const EVENT_BEFORE_REGISTER = 'beforeRegister';
    const EVENT_AFTER_REGISTER = 'afterRegister';

    public function getViewPath(){
      return Yii::getAlias('@app/views/user/registration');
    }

    // public function actionResend(){
    //
    // }

    public function actionRegister(){

      $possibleUserTypes = [
        'client',
        'designer',
      ];

      $userType = $_GET['userType'];

      /** @var RegistrationForm $model */
      $model = \Yii::createObject(RegistrationForm::className());
      $event = $this->getFormEvent($model);

      $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

      $this->performAjaxValidation($model);

      if($model->load(\Yii::$app->request->post())){

        if($userType == 'client') $model->client();
        if($userType == 'designer') $model->designer();

        if ($model->register()) {

            $this->trigger(self::EVENT_AFTER_REGISTER, $event);
            return $this->redirect(['/site/index']);
        }

      }

      if(in_array($userType, $possibleUserTypes)){
        return $this->render($userType.'-register', [
            'model' => $model,
        ]);
      }else{
        $this->redirect(['/site/index']);
      }


    }
}
