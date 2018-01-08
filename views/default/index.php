<?php

use cinghie\plupload\PluploadFullAsset;

$this->title = Yii::t('media', 'Media');
$this->params['breadcrumbs'][] = $this->title;

// Load Plupload Asset
PluploadFullAsset::register($this);

?>
