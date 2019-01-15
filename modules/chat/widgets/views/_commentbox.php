<?php
use richardfan\widget\JSRegister;
?>

<div class="form-group shadow-textarea">
    <label for="<?= $commentboxId ?>"><? $label ?></label>
    <textarea id="<?= $commentboxId ?>" class="form-control z-depth-1" rows="3" placeholder="<?= $placeholder ?>"></textarea>
</div>
<button id=<?= $commentboxButtonId ?> type="button" class="btn btn-designship">Send</button>

<?php JSRegister::begin(); ?>
<script>

$('#<?= $commentboxButtonId?>').on('click',function(){
  $.post('<?= Yii::$app->urlManager->createAbsoluteUrl(['/chat/message/send','groupId'=>$group->id]) ?>',
  {
    content: $('#<?= $commentboxId?>').val(),
  },
  function(result){
    if (result.success) {
      window.location.reload()
    }
  });

});

</script>
<?php JSRegister::end(); ?>
