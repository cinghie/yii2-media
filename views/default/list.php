<?php

/**
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model cinghie\media\models\Media
 * @var $searchModel cinghie\media\models\MediaSearch
 * @var $this yii\web\View
 */

use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::t('media', 'Media');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = Yii::t('traits', 'List');

// Register action buttons js
$this->registerJs('$(document).ready(function() 
    {'
	.$searchModel->getUpdateButtonJavascript('#w1')
	.$searchModel->getDeleteButtonJavascript('#w1').
	'});
');

?>

<?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-media/views/default/_navbar.php', [
	'searchModel' => $searchModel
]) ?>

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

	<?= GridView::widget([
		'dataProvider'=> $dataProvider,
		'filterModel' => $searchModel,
		'containerOptions' => [
			'class' => 'media-pjax-container'
		],
		'pjax' => true,
		'pjaxSettings'=>[
			'neverTimeout'=>true,
		],
		'columns' => [
			[
				'class' => CheckboxColumn::class
			],
			[
				'attribute' => Yii::t('traits', 'Preview'),
				'format' => 'raw',
				'hAlign' => 'center',
				'width' => '8%',
				'value' => function ($model) {
					/** @var $model cinghie\media\models\Media */
					$html  = '<div class="text-center" style="display: block; position:relative;">';
					$html .= Html::img($model->getMediaThumbsUrl(),['class' => 'img-responsive', 'width' => '78px']);
					if (strpos($model->mimetype, 'video') !== false) {
						$html .= '<span style="color: #FFF; position:absolute; left: 40%; top: 30%;"><i class="fa fa-play" aria-hidden="true"></i></span>';
					}
					$html .= '</div>';

					return $html;
				},
			],
			[
				'attribute' => 'title',
				'format' => 'html',
				'hAlign' => 'center',
				'value' => function ($model) {
					/** @var $model cinghie\media\models\Media */
					$url = urldecode(Url::toRoute(['/media/items/update', 'id' => $model->id ]));
					return Html::a($model->title,$url).'<br>('.$model->filename.')';
				}
			],
			[
				'attribute' => 'reference',
				'width' => '7%',
				'hAlign' => 'center',
			],
			[
				'attribute' => 'size',
				'width' => '7%',
				'hAlign' => 'center',
				'value' => function ($model) {
					/** @var $model cinghie\media\models\Media */
					return $model->getFormattedSize();
				}
			],
			[
				'attribute' => 'duration',
				'format' => 'html',
				'width' => '6%',
				'hAlign' => 'center',
                'value' => function ($model) {
	                /** @var $model cinghie\media\models\Media */
	                return $model->duration !== null ? $model->duration : '<span class="fa fa-ban text-danger"></span>';
                }
			],
			[
				'attribute' => 'extension',
				'width' => '7%',
				'hAlign' => 'center',
			],
            /**[
				'attribute' => 'mimetype',
				'format' => 'html',
				'hAlign' => 'center',
				'width' => '7%',
				'value' => function ($model) {
					return $model->getAttachmentTypeIcon();
				}
			],**/
			[
				'attribute' => 'id',
				'width' => '5%',
				'hAlign' => 'center',
			]
		],
		'responsive' => true,
		'responsiveWrap' => true,
		'hover' => true,
		'panel' => [
			'heading' => '<h3 class="panel-title"><i class="fa fa-cloud-upload"></i></h3>',
			'type' => 'success',
		]
	]) ?>

</div>
