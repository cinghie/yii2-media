<?php

use cinghie\plupload\PluploadFullAsset;
use kartik\widgets\FileInput;
use yii\helpers\Url;

$this->title = Yii::t('media', 'Media');
$this->params['breadcrumbs'][] = $this->title;

// Load Plupload Asset
PluploadFullAsset::register($this);

echo FileInput::widget([
	'name' => 'items[]',
	'options'=>[
		'multiple'=>true
	],
	'pluginOptions' => [
		'uploadUrl' => Url::to(['/site/file-upload']),
		'uploadExtraData' => [
			'album_id' => 20,
			'cat_id' => 'Nature'
		],
		'maxFileCount' => 10
	]
]);

?>
