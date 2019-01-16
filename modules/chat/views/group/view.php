<?php

use app\modules\chat\models\Group;
use app\modules\chat\models\Message;
use app\modules\chat\widgets\Comment;
use app\modules\chat\widgets\CommentBox;
use richardfan\widget\JSRegister;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\chat\models\Group */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="message-container">
        <?php $messages = Message::find()->where(['chat_group_id' => $model->id])->all(); ?>
        <?php foreach ($messages as $message): ?>

            <div class="row">
                <div class="col-sm-6 <?= $message->user->id != Yii::$app->user->id ? "col-sm-offset-6" : "" ?>">
                    <?= Comment::widget(['message' => $message]) ?>
                </div>
            </div>


        <?php endforeach; ?>
    </div>
    <?= CommentBox::widget(['groupId' => $model->id]) ?>
</div>


<?php JSRegister::begin(); ?>
<script>

    Array.prototype.diff = function (a) {
        return this.filter(function (i) {
            return a.indexOf(i) < 0;
        });
    };

    var renderedCommentIds = <?= json_encode(ArrayHelper::getColumn($messages, 'id'))?>; //contains the already rendered comment ids

    setInterval(function () {

        $.get('<?= Yii::$app->urlManager->createAbsoluteUrl(['/chat/message/get-message-ids', 'groupId' => $model->id]) ?>', // returns an array e.g. [12, 13, 14]
            function (result) {
                diff = result.diff(renderedCommentIds); //diff will contain all the new non-rendered comment ids
                if (diff.length > 0) {
                    renderedCommentIds = result; //refresh the array, so next time do not reload the same comments

                    $.each(diff, function (index, messageId) {
                        $.post('<?= Yii::$app->urlManager->createAbsoluteUrl(['/chat/message/render-comment']) ?>?id=' + messageId, function (result) {
                            $('.message-container').append('<div class="row"><div class="col-sm-offset-6 col-sm-6">' + result + '</div></div>');
                        });
                    });

                }

            });

    }, 15000); //every 15 sec

</script>
<?php JSRegister::end(); ?>
