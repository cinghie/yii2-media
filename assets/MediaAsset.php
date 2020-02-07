<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.6.6
 */

namespace cinghie\media\assets;

use cinghie\masonry\MasonryMinifyAsset;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Class MediaAsset
 */
class MediaAsset extends AssetBundle
{
	/**
	 * @inherit
	 */
	public $sourcePath = '@vendor/cinghie/yii2-media/assets/assets';

	/**
	 * @inherit
	 */
	public $css = array(
		'css/media.css',
	);

	/**
	 * @inherit
	 */
	public $js = array(
		'js/media.js',
	);

	/**
	 * @inherit
	 */
	public $depends = [
		YiiAsset::class,
		BootstrapAsset::class,
		BootstrapPluginAsset::class,
		MasonryMinifyAsset::class,
	];
}
