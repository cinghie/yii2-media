<?php

use yii\bootstrap\Nav;

$items = [
	[
		'label' => Yii::t('media', 'Media'),
		'url' => ['/media/default/index'],
	]
];

if(Yii::$app->getModule('media')->showTinify) {
	$items[] = [
		'label' => Yii::t('media', 'Tinify'),
		'url' => ['/media/default/tinify'],
	];
}

echo Nav::widget([
	'options' => [
		'class' => 'nav-tabs',
		'style' => 'margin-bottom: 15px',
	],
	'items' => $items
]);
