<?php

use app\modules\chat\widgets\Comment;
use app\modules\chat\widgets\CommentBox;

use app\modules\chat\models\Message;

use richardfan\widget\JSRegister;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\chat\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Messages';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="message-index">

  <div class="message-container">
    <?php $messages =  Message::find()->all(); ?>
    <?php foreach ($messages as $message): ?>

      <div class="row">
        <div class="col-sm-6">
          <?= Comment::widget(['message'=>$message]) ?>
        </div>
      </div>


    <?php endforeach; ?>
  </div>

  <?= CommentBox::widget(['groupId'=>1]) ?>
</div>

<?php JSRegister::begin(); ?>
<script>

Array.prototype.diff = function(a) {
    return this.filter(function(i) {return a.indexOf(i) < 0;});
};

var renderedCommentIds = <?= json_encode(ArrayHelper::getColumn($messages,'id'))?>; //contains the already rendered comment ids

setInterval(function(){

$.get('<?= Yii::$app->urlManager->createAbsoluteUrl(['/chat/message/get-message-ids','groupId'=>1]) ?>', // returns an array e.g. [12, 13, 14]
function(result){
  diff = result.diff(renderedCommentIds); //diff will contain all the new non-rendered comment ids
  if (diff.length > 0) {
    renderedCommentIds = result; //refresh the array, so next time do not reload the same comments

    $.each(diff,function(index, messageId){
      $.post('<?= Yii::$app->urlManager->createAbsoluteUrl(['/chat/message/render-comment']) ?>?id='+messageId,function(result){
        $('.message-container').append('<div class="row"><div class="col-sm-6">'+result+'</div></div>');
      });
    });

  }

});

},15000); //every 15 sec

</script>
<?php JSRegister::end(); ?>
