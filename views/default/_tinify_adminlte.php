<?php

/**
 * @var $form kartik\widgets\ActiveForm
 * @var $model cinghie\media\models\MediaSettings
 * @var $this yii\web\View
 */

use kartik\widgets\SwitchInput;
use yii\helpers\Html;

?>

<div class="row">

	<div class="col-md-8">

		<div class="box box-primary">

			<div class="box-header with-border">
				<h3 class="box-title">
					<?= Yii::t('media','Tinify Informations') ?>
				</h3>
			</div>
			<!-- /.box-header -->

			<div class="box-body">

				<div class="col-md-4">

					<?= Html::img('https://tinypng.com/images/panda-chewing-2x.png', [
						'class' => 'img-responsive',
						'alt' => 'My logo',
						'wwidth' => '85%'
					]) ?>

				</div>

				<div class="col-md-8">

					<h2 class="text-center">
						<?= $model->getTinify()->compressCount().' / 500<br>' ?>
					</h2>
					<h4 class="text-center">
						<?= Yii::t('media','Images tinified this month') ?>
					</h4>

					<hr>

					<h2 class="text-center">
						14,3 MB (16%)
					</h2>
					<h4 class="text-center">
						<?= Yii::t('media','Total Savings') ?>
					</h4>

				</div>

			</div>
			<!-- /.box-body -->

		</div>
		<!-- /.box -->

	</div>

	<div class="col-md-4">

		<div class="box box-primary box-solid">

			<div class="box-header with-border">
				<h3 class="box-title">
					<?= Yii::t('media','Tinify Settings') ?>
				</h3>
			</div>
			<!-- /.box-header -->

			<div class="box-body">

				<div class="row">

					<div class="col-md-6">

						<?= $form->field($model, 'tinifyActive')->widget(SwitchInput::class, [
							'indeterminateValue' => '0',
							'pluginOptions' => [
								'onColor' => 'success',
								'offColor' => 'danger'
							]
						]) ?>

					</div>

					<div class="col-md-6">

						<?= $form->field($model, 'tinifyAutomatic')->widget(SwitchInput::class, [
							'indeterminateValue' => '0',
							'pluginOptions' => [
								'onColor' => 'success',
								'offColor' => 'danger'
							]
						]) ?>

					</div>

				</div>

				<?= $form->field($model, 'tinifyCode', [
					'addon' => [
						'prepend' => [
							'content'=>'<i class="fa fa-key"></i>'
						]
					],
				])->textInput() ?>

				<div>
					<a href="https://tinypng.com/developers" class="btn btn-primary" role="button" target="_blank">
						<?= Yii::t('media','Get your API Key') ?>
					</a>
				</div>

			</div>
			<!-- /.box-body -->

		</div>
		<!-- /.box -->

	</div>

</div>
