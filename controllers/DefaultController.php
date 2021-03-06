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

namespace cinghie\media\controllers;

use Exception;
use RuntimeException;
use Throwable;
use Yii;
use cinghie\media\models\Media;
use cinghie\media\models\MediaSearch;
use cinghie\media\models\MediaSettings;
use pheme\settings\SettingsAction;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'actions' => ['index','view','list','tinify','delete','deletemultiple','deleteonfly'],
						'roles' => $this->module->mediaRoles
					],
				],
				'denyCallback' => static function () {
					throw new RuntimeException(Yii::t('traits','You are not allowed to access this page'));
				}
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'delete' => ['post'],
					'deletemultiple' => ['post'],
					'deleteonfly' => ['post'],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'tinify' => [
				'class' => SettingsAction::class,
				'modelClass' => MediaSettings::class,
				'viewName' => 'tinify'
			],
		];
	}

	/**
	 * Displays a single Media Modal
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws InvalidParamException
	 * @throws NotFoundHttpException
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		return $this->renderAjax('view', [
			'model' => $model
		]);
	}

	/**
	 * Display all Media models on Grid View
	 *
	 * @return string
	 * @throws Exception
	 */
	public function actionIndex()
    {
    	$model = new Media();
	    $post  = Yii::$app->request->post();

	    $searchModel  = new MediaSearch();
	    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

	    if ($model->load($post))
	    {
		    // Create UploadFile Instance
		    $model->items = UploadedFile::getInstances($model, 'items');

		    foreach ($model->items as $item) {
			    $model->uploadMedia($item);
		    }
	    }

        return $this->render('index', [
	        'model' => $model,
	        'searchModel'  => $searchModel,
	        'dataProvider' => $dataProvider
        ]);
    }

	/**
	 * Display all Media models on List View
	 *
	 * @return string
	 * @throws Exception
	 */
	public function actionList()
	{
		$model = new Media();
		$post  = Yii::$app->request->post();

		$searchModel  = new MediaSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		if ($model->load($post))
		{
			// Create UploadFile Instance
			$model->items = UploadedFile::getInstances($model, 'items');

			foreach ($model->items as $item) {
				$model->uploadMedia($item);
			}
		}

		return $this->render('list', [
			'model' => $model,
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider
		]);
	}

	/**
	 * Deletes an existing Attachments model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param $id
	 *
	 * @return Response
	 * @throws StaleObjectException
	 * @throws Throwable
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);

		if ($model->delete()) {
			Yii::$app->session->setFlash('success', Yii::t('media', 'Media has been deleted!'));
		} else {
			Yii::$app->session->setFlash('error', Yii::t('media', 'Error deleting Media!'));
		}

		return $this->redirect(['index']);
	}

	/**
	 * Deletes selected Attachments models.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @throws NotFoundHttpException
	 * @throws StaleObjectException
	 * @throws Throwable
	 */
	public function actionDeletemultiple()
	{
		$ids = Yii::$app->request->post('ids');

		if (!$ids) {
			return;
		}

		foreach ($ids as $id)
		{
			$model = $this->findModel($id);

			if ($model->delete()) {
				Yii::$app->session->setFlash('success', Yii::t('media', 'Media has been deleted!'));
			} else {
				Yii::$app->session->setFlash('error', Yii::t('media', 'Error deleting Media!'));
			}
		}
	}

	/**
	 * Deletes an existing Attachments model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 *
	 * @return bool
	 * @throws Exception
	 * @throws NotFoundHttpException
	 * @throws StaleObjectException
	 * @throws Throwable
	 */
	public function actionDeleteonfly($id)
	{
		$model = $this->findModel($id);

		if ($model->delete()) {
			Yii::$app->session->setFlash('success', Yii::t('media', 'Media has been deleted!'));
			return true;
		}

		Yii::$app->session->setFlash('error', Yii::t('media', 'Error deleting Media!'));
		return false;
	}

	/**
	 * Finds the Media model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return Media
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id)
	{
		if (($model = Media::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException(Yii::t('traits','The requested page does not exist.'));
	}
}
