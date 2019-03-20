<?php

/**
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model cinghie\media\models\Media
 * @var $searchModel cinghie\media\models\MediaSearch
 * @var $this yii\web\View
 */

use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

$this->title = Yii::t('media', 'Media');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = Yii::t('traits', 'Grid');

// Register action buttons js
$this->registerJs('$(document).ready(function() 
    {'
	.$searchModel->getUpdateButtonJavascript('#w2')
	.$searchModel->getDeleteButtonJavascript('#w2').
	'});
');

// Register Modal
$this->registerJs("$(function(){
    // changed id to class
    $('.modalButton').click(function (){
        $.get($(this).attr('href'), function(data) {
          $('#modal').modal('show').find('#modalContent').html(data)
       });
       return false;
    });
}); ");

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

<?= $model->getMediasGrid($dataProvider) ?>

<?php
    Modal::begin([
        'header' => Yii::t('media','Media Manager'),
        'id' => 'modal',
        'size' => 'xl',
        'options' => []
    ]);

    echo '<div id="modalContent"></div>';

    Modal::end();
?>
