<?php

use yii\bootstrap\Nav;

?>

<?= Nav::widget([
	'options' => [
		'class' => 'nav-tabs',
		'style' => 'margin-bottom: 15px',
	],
	'items' => [
		[
			'label'   => Yii::t('media', 'Media'),
			'url'     => ['/media/default/index'],
		],
		[
			'label'   => Yii::t('media', 'Tinify'),
			'url'     => ['/media/default/tinify'],
		],
	],
]) ?>