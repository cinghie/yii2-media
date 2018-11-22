<div class="row">

	<div class="col-md-6 pull-left text-left">


	</div>

    <div class="col-md-6">

        <?php
            if(Yii::$app->controller->action->id === 'index') {
                echo $searchModel->getStandardButton('fa fa-list-ul', Yii::t('traits','List'), ['list'], [ 'class' => 'btn btn-mini' ]);
            } else {
                echo $searchModel->getStandardButton('fa fa-th', Yii::t('traits','Grid'), ['index'], [ 'class' => 'btn btn-mini' ]);
            }
        ?>

	    <?= $searchModel->getUpdateButton() ?>

	    <?= $searchModel->getCreateButton() ?>

    </div>

</div>

<div class="separator"></div>
