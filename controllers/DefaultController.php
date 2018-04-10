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

use cinghie\media\models\Media;

class DefaultController extends \yii\web\Controller
{

	/**
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

}
