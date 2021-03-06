<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-media
 * @license BSD-3-Clause
 * @package yii2-media
 * @version 0.1.0
 */

namespace cinghie\media\models;

use Yii;
use cinghie\traits\CacheTrait;
use cinghie\traits\ViewsHelpersTrait;
use yii\base\InvalidConfigException;
use yii\web\HttpException;

/**
 * Class MediaSettings
 */
class MediaSettings extends Media
{
	use CacheTrait, ViewsHelpersTrait;

	/**
	 * @var integer $tinifyActive
	 */
	public $tinifyActive;

	/**
	 * @var integer $tinifyAutomatic
	 */
	public $tinifyAutomatic;

	/**
	 * @var string $tinifyCode
	 */
	public $tinifyCode;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['tinifyActive','tinifyAutomatic'], 'integer'],
			[['tinifyCode'], 'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'tinifyActive' => Yii::t('media', 'Active Tinify'),
			'tinifyAutomatic' => Yii::t('media', 'Automatic Tinify'),
			'tinifyCode' => Yii::t('media', 'Tinify Code'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function fields()
	{
		return ['tinifyActive', 'tinifyAutomatic', 'tinifyCode'];
	}

	/**
	 * @inheritdoc
	 */
	public function attributes()
	{
		return ['tinifyActive', 'tinifyAutomatic', 'tinifyCode'];
	}

	/**
	 * Flush Cache on Init
	 *
	 * @throws HttpException
	 * @throws InvalidConfigException
	 */
	public function init()
	{
		parent::init();

		$caches = $this->findCaches();

		foreach($caches as $cache)
		{
			if($this->getCache($cache['name'])) {
				$this->getCache($cache['name'])->flush();
			}
		}
	}
}
