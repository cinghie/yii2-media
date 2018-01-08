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

	// Controller Namespace
	public $controllerNamespace = 'cinghie\media\controllers';

	// Select Attachment Types allowed
	public $attachType = ['jpg','jpeg','gif','png','csv','pdf','txt','doc','docs'];

	// Menu Rules
	public $menuRoles = ['admin'];

	// Show Titles in the views
	public $showTitles = true;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		$this->registerTranslations();
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

}
