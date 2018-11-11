<?php

/**
 * @var $form kartik\widgets\ActiveForm
 * @var $model cinghie\media\models\MediaSettings
 * @var $this yii\web\View
 */

use kartik\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;

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

    <div class="row">

        <div class="col-md-12">

            <div class="box box-solid">

                <!-- /.box-header -->
                <div class="box-body">

                    <div class="col-md-3">

                        <?= Html::img('https://tinypng.com/images/panda-chewing-2x.png', [
                            'class' => 'img-responsive',
                            'alt' => 'My logo',
                            'width' => '70%'
                        ]) ?>

                    </div>

                    <div class="col-md-6">

                    </div>

                    <div class="col-md-3">

	                    <?= $form->field($model, 'tinifyActive')->widget(SwitchInput::class, [
		                    'indeterminateValue' => '0',
		                    'pluginOptions' => [
			                    'onColor' => 'success',
			                    'offColor' => 'danger'
		                    ]
	                    ]) ?>

	                    <?= $form->field($model, 'tinifyAutomatic')->widget(SwitchInput::class, [
		                    'indeterminateValue' => '0',
		                    'pluginOptions' => [
			                    'onColor' => 'success',
			                    'offColor' => 'danger'
		                    ]
	                    ]) ?>

	                    <?= $form->field($model, 'tinifyCode', [
		                    'addon' => [
			                    'prepend' => [
				                    'content'=>'<i class="fa fa-key"></i>'
			                    ]
		                    ],
	                    ])->textInput() ?>

                    </div>

                </div>
                <!-- /.box-body -->

            </div>
            <!-- /.box -->

        </div>

    </div>

<?php ActiveForm::end() ?>
