<?php

/**
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model cinghie\media\models\Media
 * @var $searchModel cinghie\media\models\MediaSearch
 * @var $this yii\web\View
 */

$this->title = Yii::t('media', 'Media');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-media/views/default/_navbar.php', [
	'searchModel' => $searchModel
]) ?>

<div class="row">
	<div class="col-md-12">
		<div class="collapse" id="collapseMedia">
			<?= $model->getMediasWidget() ?>
		</div>
	</div>
</div>

<div class="clearfix"></div>

<?= $model->getMediasGrid($dataProvider); ?>