<?php

/** @var \cinghie\media\models\Media $model */

use yii\bootstrap\Html;

$this->registerCss('
    #modal {
        padding-left: 0!important;
        padding-right: 0!important;
    }
    .modal-dialog.xl {
        width: 90%;
    }
    .modal-image, .modal-info {
        margin: 25px auto;
    }
    .modal-info {
        font-size: 14px;
        line-height: 20px;
    }
');

?>

<div class="row">

	<div class="col-sm-7 modal-image">

		<?php

		if (strpos($model->mimetype, 'video') !== false) {

		    echo $model->getVideoPlayer();

		} else {

			echo Html::img($model->getMediaThumbsUrl(),[
				'class' => 'img-responsive text-center',
				'style' => 'margin: 0 auto;'
			]);

        } ?>

	</div>

	<div class="col-sm-5 modal-info" style="font-size: 14px; margin-top: 45px;">

        <span class="modal-title"><strong><?= Yii::t('traits','Title') ?></strong>: <?= $model->title ?></span><br>
        <span class="modal-filename"><strong><?= Yii::t('traits','Filename') ?></strong>: <?= $model->filename ?></span><br>
        <span class="modal-mymetype"><strong><?= Yii::t('traits','MimeType') ?></strong>: <?= $model->mimetype ?></span><br>
        <span class="modal-created"><strong><?= Yii::t('traits','Created') ?></strong>: <?= $model->created ?></span><br>
        <span class="modal-createdby"><strong><?= Yii::t('traits','Created By') ?></strong>: <?= $model->createdBy->username ?></span><br>
        <span class="modal-size"><strong><?= Yii::t('traits','Size') ?></strong>: <?= $model->formatSize() ?></span><br>

	</div>

</div>