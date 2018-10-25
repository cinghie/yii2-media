<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-media
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-media
 * @version 0.1.0
 */

namespace cinghie\media;

use Yii;
use yii\base\Module;
use yii\i18n\PhpMessageSource;

class Media extends Module
{
	// Select Media Name: casual or original
	public $mediaNameType = 'casual';
	
	// Select Path To Upload Media
	public $mediaPath = '@webroot/media/';

	// Select Path To Upload Media Thumbs
	public $mediaThumbsPath = '@webroot/media/thumbs/';

	// Select URL To Media Files
	public $mediaURL  = '@web/media/';

	// Select URL To Media Thumbs Files
	public $mediaThumbsURL  = '@web/media/thumbs/';

	// Select Media Thumbs Options
	public $mediaThumbsOptions =	[
		'small'  => ['quality' => 90, 'width' => 250, 'height' => 250],
		'medium' => ['quality' => 90, 'width' => 680, 'height' => 680],
		'large'  => ['quality' => 90, 'width' => 1280, 'height' => 1280],
		'extra'  => ['quality' => 90, 'width' => 1980, 'height' => 1980],
	];

	// Select Media Types allowed
	public $mediaType = ['svg','jpg','jpeg','gif','png','csv','xls','xlx','pdf','txt','doc','docs','mp3','mp4'];

	// Media Rules
	public $mediaRoles = ['admin'];

	// Slugify Options
	public $slugifyOptions = [
		'separator' => '-',
		'lowercase' => true,
		'trim' => true,
		'rulesets'  => [
			'default'
		]
	];

	// Show Titles in the views
	public $showTitles = true;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		$this->createMediaDirectory();
		$this->createMediaThumbsDirectory();
		$this->copyDefaultImage();
		$this->registerTranslations();
		parent::init();
	}

	/**
	 * Translating module message
	 */
	public function registerTranslations()
	{
		if (!isset(Yii::$app->i18n->translations['media*']))
		{
			Yii::$app->i18n->translations['media*'] = [
				'class' => PhpMessageSource::class,
				'basePath' => __DIR__ . '/messages',
			];
		}
	}

	/**
	 * Creating directory to save Media if not exist
	 */
	protected function createMediaDirectory()
	{
		if(!file_exists(Yii::getAlias($this->mediaPath)) && !mkdir($concurrentDirectory = $this->mediaPath, 0755, true) && !is_dir($concurrentDirectory))
		{
			throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
		}
	}

	/**
	 * Creating directory to save Media Thumbs if not exist
	 */
	protected function createMediaThumbsDirectory()
	{
		$thumbsPath = Yii::getAlias($this->mediaThumbsPath);

		$sizes = array(
			'small',
			'medium',
			'large',
			'extra',
		);

		foreach($sizes as $size)
		{
			if(!file_exists($thumbsPath . $size) && !mkdir($concurrentDirectory = $thumbsPath . $size, 0755, true) && !is_dir($concurrentDirectory))
			{
				throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
			}
		}
	}

	/**
	 * Creating directory to save Media if not exist
	 */
	protected function copyDefaultImage()
	{
		$sourceImage  = Yii::getAlias('@vendor/cinghie/yii2-media/media/image-not-found.jpg');
		$defaultImage = Yii::getAlias($this->mediaPath).'image-not-found.jpg';

		if(!file_exists($defaultImage)) {
			copy($sourceImage, $defaultImage);
		}
	}
}
