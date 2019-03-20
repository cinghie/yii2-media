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
');

?>

<div class="row">

	<div class="col-sm-7 modal-image">

		<?= Html::img($model->getMediaThumbsUrl(),['class' => 'img-responsive text-center', 'style' => 'margin: 0 auto;']) ?>

	</div>

	<div class="col-sm-5 modal-info" style="font-size: 12px">

        <strong><?= Yii::t('traits','Title') ?></strong>: <?= $model->title ?><br>
        <strong><?= Yii::t('traits','Filename') ?></strong>: <?= $model->filename ?><br>
        <strong><?= Yii::t('traits','MimeType') ?></strong>: <?= $model->mimetype ?><br>
        <strong><?= Yii::t('traits','Created') ?></strong>: <?= $model->created ?><br>
        <strong><?= Yii::t('traits','Created By') ?></strong>: <?= $model->createdBy->username ?><br>
        <strong><?= Yii::t('traits','Size') ?></strong>: <?= $model->getFormattedSize() ?><br>

	</div>

</div>