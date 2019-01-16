<?php
    use app\modules\chat\models\Group;
    use app\modules\chat\models\Member;
    use lajax\translatemanager\helpers\Language as Lx;
?>

<?php
    $members = collect(Member::find()->where(['user_id'=>Yii::$app->user->id])->all());
    $groups = $members->map(function($member){
        return $member->group;
    })->toArray();
    $projectIds = \yii\helpers\ArrayHelper::getColumn($groups,'project_id');
    $groupMap = \yii\helpers\ArrayHelper::map($groups,'project_id','id');
    $projects = collect(\app\models\Project::find()->where(['id'=>$projectIds])->all());
?>

<div class="container">
    <h1><?= Lx::t('system', 'Chats') ?></h1>
    <?php foreach ($projects->chunk(2) as $chunk): ?>
        <?= \app\widgets\projectcard\ProjectCard::beginContainer()?>
        <?= \app\widgets\projectcard\ProjectCard::beginBlock()?>
        <?php foreach ($chunk as $project): ?>

            <?php
                if($project->status === \app\models\Project::STATUS_FINALIST){
                    $cover = Yii::$app->urlManager->createAbsoluteUrl([$project->finalistAssignment->cover]);
                }else if($project->status === \app\models\Project::STATUS_FINISHED) {
                    $cover = Yii::$app->urlManager->createAbsoluteUrl([$project->winnerAssignment->cover]);
                }else{
                    $cover = Yii::$app->urlManager->createAbsoluteUrl(['img/active.png']);
                }
            ?>

            <?= \app\widgets\projectcard\ProjectCard::widget([
                'img' => $cover,
                'url' => \yii\helpers\Url::to(['/chat/group/view','id'=>$groupMap[$project->id]]),
                'header' => $project->title,
                'paragraph' => '',
            ]) ?>
        <?php endforeach; ?>
        <?= \app\widgets\projectcard\ProjectCard::endBlock()?>
        <?= \app\widgets\projectcard\ProjectCard::endContainer()?>
    <?php endforeach; ?>
</div>
