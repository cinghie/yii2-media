<?php

/** @var Media $model */

use cinghie\media\models\Media;
use kartik\helpers\Html;

?>

<div class="row">

	<div class="col-sm-7 text-center modal-image">
		<?php
            if (strpos($model->mimetype, 'video') !== false) {
                echo $model->getVideoPlayer();
            } else {
                echo $model->getMediaThumbsUrl();
            }
		?>
	</div>

	<div class="col-sm-5 modal-info" style="font-size: 14px; margin-top: 45px;">
        <span class="modal-title">
            <strong><?= Yii::t('traits','Title') ?></strong>: <?= $model->title ?>
        </span><br>
        <span class="modal-filename">
            <strong><?= Yii::t('traits','Filename') ?></strong>: <?= $model->filename ?>
        </span><br>
        <span class="modal-mymetype">
            <strong><?= Yii::t('traits','MimeType') ?></strong>: <?= $model->mimetype ?>
        </span><br>
        <span class="modal-created">
            <strong><?= Yii::t('traits','Created') ?></strong>: <?= $model->created ?>
        </span><br>
        <span class="modal-createdby">
            <strong><?= Yii::t('traits','Created By') ?></strong>: <a href="<?= $model->getUserAdminUrl($model->createdBy->id) ?>" title="<?= $model->createdBy->username ?>"><?= $model->createdBy->username ?></a>
        </span><br>
        <span class="modal-size">
            <strong><?= Yii::t('traits','Size') ?></strong>: <?= $model->formatSize() ?>
        </span><br><br><br>
        <span class="modal-delete">
            <?= Html::a(Yii::t('traits','Delete'), ['delete', 'id' => $model->id], [
                'class'=>'button-secondary button-large',
                'data' => [
	                'confirm' => Yii::t('traits', 'Do you want delete selected items?'),
	                'method' => 'post',
                ],
            ]) ?>
        </span>
	</div>

</div>