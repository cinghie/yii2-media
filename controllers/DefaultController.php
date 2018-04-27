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

namespace cinghie\media\controllers;

use Yii;
use cinghie\media\models\Media;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DefaultController extends \yii\web\Controller
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['index','list','delete'],
						'roles' => $this->module->mediaRoles
					],
				],
				'denyCallback' => function () {
					throw new \RuntimeException(Yii::t('traits','You are not allowed to access this page'));
				}
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	/**
	 * Display all Media models on Grid View
	 *
	 * @return string
	 * @throws \yii\base\InvalidArgumentException
	 */
	public function actionIndex()
    {
    	$model = new Media();

        return $this->render('index', [
	        'model' => $model
        ]);
    }

	/**
	 * Display all Media models on List View
	 *
	 * @return string
	 * @throws \yii\base\InvalidArgumentException
	 */
	public function actionList()
	{
		$model = new Media();

		return $this->render('list', [
			'model' => $model
		]);
	}

}
