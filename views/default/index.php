<?php

use cinghie\plupload\PluploadFullAsset;
use kartik\widgets\FileInput;
use yii\helpers\Url;

$this->title = Yii::t('media', 'Media');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-media/views/default/_navbar.php'); ?>

<div class="row">
	<div class="col-md-12">
		<div class="collapse" id="collapseMedia">
			<?= $model->getMediasWidget() ?>
		</div>
	</div>
</div>