<?php

/**
 * @var $searchModel MediaSearch
 */

use cinghie\media\models\MediaSearch;

?>

<div class="row media-navbar">

	<div class="col-md-6 media-navbar-menu">
        <?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-media/views/default/_menu.php') ?>
	</div>

    <div class="col-md-6 media-navbar-actions">

        <?php
            if(Yii::$app->controller->action->id === 'index') {
                echo $searchModel->getStandardButton('fa fa-list-ul', Yii::t('traits','List'), ['list'], [ 'class' => 'btn btn-mini' ]);
            } else {
                echo $searchModel->getStandardButton('fa fa-th', Yii::t('traits','Grid'), ['index'], [ 'class' => 'btn btn-mini' ]);
            }
        ?>

        <?= $searchModel->getDeleteButton() ?>

	    <?= $searchModel->getUpdateButton() ?>

	    <?= $searchModel->getCreateButton() ?>

    </div>

</div>

<div class="separator"></div>
