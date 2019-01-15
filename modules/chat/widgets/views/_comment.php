<?php
use app\modules\chat\assets\CommentAsset;

CommentAsset::register($this);
?>

<div class="panel panel-white post panel-shadow">
    <div class="post-heading">
        <div class="pull-left image">
            <img src="<?= $avatarUrl ?>" class="img-circle avatar" alt="user profile image">
        </div>
        <div class="pull-left meta">
            <div class="title h5">
                <a href="#"><b><?= $username ?></b></a>
                <?= $action //made a post?>
            </div>
            <h6 class="text-muted time"><?= $when ?></h6>
        </div>
    </div>
    <div class="post-description">
        <p><?= $message ?></p>
        <!-- <div class="stats">
            <a href="#" class="btn btn-default stat-item">
                <i class="fa fa-thumbs-up icon"></i>0
            </a>
            <a href="#" class="btn btn-default stat-item">
                <i class="fa fa-thumbs-down icon"></i>0
            </a>
        </div> -->
    </div>
</div>
