<?php

namespace app\modules\chat\controllers;

use Yii;

use app\modules\chat\models\Message;
use app\modules\chat\models\MessageSearch;
use app\modules\chat\widgets\Comment;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSend($groupId){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new Message;
        $model->scenario = Message::SCENARIO_SELF_VALIDATOR;
        $model->user_id = Yii::$app->user->id;
        $model->chat_group_id = $groupId;
        $model->content = $_POST['content'];
        if($model->save()){
          $group = $model->group;
          $group->last_message_id = $model->id;
          $group->save();
          return [
            'success' => true,
            'message' => $model,
          ];
        }else{
          return [
            'errors' => $model->getErrors()
          ];
        }

    }

    public function actionGetMessageIds($groupId){
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $messages = Message::find()->where(['chat_group_id'=>$groupId])->all();
      return ArrayHelper::getColumn($messages,'id');
    }

    public function actionGetMessages($groupId){
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $messages = Message::find()->where(['chat_group_id'=>$groupId])->all();
      return [
        'messages' => $messages
      ];
    }

    public function actionRenderComment($id){
      $message = Message::findOne($id);
      return Comment::widget(['message'=>$message]);
    }

    /**
     * Displays a single Message model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Message();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
