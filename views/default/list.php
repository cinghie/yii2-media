<?php

/**
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model cinghie\media\models\Media
 * @var $searchModel cinghie\media\models\MediaSearch
 * @var $this yii\web\View
 */

use kartik\helpers\Html;
use kartik\widgets\ActiveForm;

$this->title = Yii::t('media', 'Media');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = Yii::t('traits', 'List');

// Register action buttons js
$this->registerJs('$(document).ready(function() 
    {'
	.$searchModel->getUpdateButtonJavascript('#w2')
	.$searchModel->getDeleteButtonJavascript('#w2').
	'});
');

?>

<div class="row">

    <div class="col-md-6">

		<?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-media/views/default/_menu.php') ?>

    </div>

    <div class="col-md-6">

		<?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-media/views/default/_navbar.php', [
			'searchModel' => $searchModel
		]) ?>

    </div>

</div>

<div class="row">

    <div class="col-md-12">

        <div class="collapse" id="collapseMedia">

			<?php $form = ActiveForm::begin(['options' => ['enctype' =>'multipart/form-data']]) ?>

			    <?= $model->getMediasWidget() ?>

			<?php ActiveForm::end() ?>

        </div>

    </div>

</div>

<div class="clearfix"></div>

<div class="separator"></div>

<div class="media-list">

	<?php if(Yii::$app->getModule('media')->showTitles): ?>
		<div class="page-header">
			<h1><?= Html::encode($this->title) ?></h1>
		</div>
	<?php endif ?>

	<?= $model->getMediaList($dataProvider,$searchModel) ?>

</div>
