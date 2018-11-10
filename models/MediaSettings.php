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

class MediaSettings
{
	use CacheTrait, ViewsHelpersTrait;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['tinifyActive'], 'integer'],
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
			'tinifyCode' => Yii::t('media', 'Tinify Code'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function fields()
	{
		return ['tinifyActive', 'tinifyCode'];
	}

	/**
	 * @inheritdoc
	 */
	public function attributes()
	{
		return ['tinifyActive', 'tinifyCode'];
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
