<?php

use cinghie\plupload\PluploadFullAsset;
use kartik\widgets\FileInput;
use yii\helpers\Url;

$this->title = Yii::t('media', 'Media');
$this->params['breadcrumbs'][] = $this->title;

// Load Plupload Asset
PluploadFullAsset::register($this);

echo $model->getMediasWidget();

?>
