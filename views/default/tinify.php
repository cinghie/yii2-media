<?php

/**
 * @var $form kartik\widgets\ActiveForm
 * @var $model cinghie\media\models\MediaSettings
 * @var $this yii\web\View
 */

use kartik\widgets\ActiveForm;

$this->title = Yii::t('media', 'Tinify');
$this->params['breadcrumbs'][] = ['label' => Yii::t('media', 'Media'), 'url' => ['/media/default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $form = ActiveForm::begin(['id' => 'media-settings-form']) ?>

    <div class="row">

        <div class="col-md-6">

            <?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-media/views/default/_menu.php') ?>

        </div>

        <div class="col-md-6">

	        <?= $model->getCancelButton() ?>

	        <?= $model->getSaveButton() ?>

        </div>

    </div>

    <div class="separator"></div>

    <?php if( file_exists(Yii::getAlias('@vendor/cinghie/yii2-admin-lte/AdminLTEAsset.php')) || file_exists(Yii::getAlias('@vendor/cinghie/yii2-admin-lte/AdminLTEMinifyAsset.php')) ): ?>

	    <?= $this->render('_tinify_adminlte', [
	        'form' => $form,
	        'model' => $model
        ]) ?>

    <?php else: ?>

	    <?= $this->render('_tinify_classic', [
		    'form' => $form,
		    'model' => $model
	    ]) ?>

    <?php endif ?>

<?php ActiveForm::end() ?>
