<?php

/**
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model cinghie\media\models\Media
 * @var $searchModel cinghie\media\models\MediaSearch
 * @var $this yii\web\View
 */

use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = Yii::t('media', 'Media');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = Yii::t('media', 'List');

?>

<?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-media/views/default/_navbar.php', [
	'searchModel' => $searchModel
]) ?>

<div class="clearfix"></div>

<div class="media-index">

	<?php if(Yii::$app->getModule('media')->showTitles): ?>
		<div class="page-header">
			<h1><?= Html::encode($this->title) ?></h1>
		</div>
	<?php endif ?>

	<div class="media-grid">

		<?php Pjax::begin() ?>

            <?= GridView::widget([
                'dataProvider'=> $dataProvider,
                'filterModel' => $searchModel,
                'containerOptions' => [
                    'class' => 'media-pjax-container'
                ],
                'pjaxSettings'=>[
                    'neverTimeout' => true,
                ],
                'columns' => [
                    [
                        'class' => '\kartik\grid\CheckboxColumn'
                    ],
                    [
                        'attribute' => Yii::t('media', 'Media'),
                        'format' => 'raw',
                        'hAlign' => 'center',
                        'width' => '8%',
                        'value' => function ($model) {
                            /** @var $model cinghie\media\models\Media */
                            return Html::img($model->getMediaUrl(),[ 'width' => '78px']);
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
                        'attribute' => 'extension',
                        'width' => '7%',
                        'hAlign' => 'center',
                    ],[
                        'attribute' => 'mimetype',
                        'format' => 'html',
                        'hAlign' => 'center',
                        'width' => '7%',
                        'value' => function ($model) {
	                        /** @var $model cinghie\media\models\Media */
                            return $model->getMimeTypeIcon();
                        }
                    ],
                    [
                        'attribute' => 'id',
                        'width' => '5%',
                        'hAlign' => 'center',
                    ]
                ],
                'responsive' => true,
                'hover' => true,
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="fa fa-cloud-upload"></i></h3>',
                    'type' => 'success',
                ],
            ]); ?>

		<?php Pjax::end() ?>

	</div>

</div>
