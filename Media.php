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

use yii\base\Module;

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
	}

}
