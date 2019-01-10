<?php

namespace app\controllers\user;

use Yii;
use app\models\User;
use dektrium\user\models\Profile;
use dektrium\user\controllers\ProfileController as BaseProfileController;
use yii\web\NotFoundHttpException;

class ProfileController extends BaseProfileController
{

  public function actionShow($id)
  {
      // $profile = $this->finder->findProfileById($id);
      $user = User::findOne($id);
      $model = $user->profile;

      if (Yii::$app->request->isPost) {
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
            return $this->refresh();
        }
      }

      if ($user === null) {
          throw new NotFoundHttpException();
      }

      return $this->render($user->role, [
          'user' => $user,
          'model' => $model,
      ]);
  }

}
