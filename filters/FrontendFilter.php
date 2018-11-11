<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-user-extended
 * @license BSD-3-Clause
 * @package yii2-user-extended
 * @version 0.6.1
 */

namespace cinghie\media\filters;

use Yii;
use yii\base\Action;
use yii\base\ActionFilter;
use yii\web\NotFoundHttpException;

/**
 * FrontendFilter is used to allow access only to admin and security controller only in backend
 */
class FrontendFilter extends ActionFilter
{

    /**
     * @var array
     */
    public $controllers = ['default'];

    /**
     * @param Action $action
     *
     * @return bool
     * @throws NotFoundHttpException
     */
    public function beforeAction($action)
    {
        if (\in_array($action->controller->id, $this->controllers, true)) {
            throw new NotFoundHttpException(Yii::t('traits','Page not found'));
        }

        return true;
    }

}
