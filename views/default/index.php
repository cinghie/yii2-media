<?php

use cinghie\plupload\PluploadFullAsset;
use kartik\widgets\FileInput;
use yii\helpers\Url;

$this->title = Yii::t('media', 'Media');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
	<div class="col-md-12">
		<a class="btn btn-default" role="button" data-toggle="collapse" href="#collapseMedia" aria-expanded="false" aria-controls="collapseMedia">
			<?= Yii::t('media','Add Media') ?>
		</a>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="collapse" id="collapseMedia">
			<?= $model->getMediasWidget() ?>
		</div>
	</div>
</div>