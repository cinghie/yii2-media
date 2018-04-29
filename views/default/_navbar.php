<div class="row" style="margin: 0 0 15px 0;">

	<div class="col-md-6 pull-left text-left">

		<?= $searchModel->getStandardButton('fa fa-list-ul', Yii::t('traits','List'), ['list'], [ 'class' => 'btn btn-mini' ], 'pull-left text-center') ?>

        <?= $searchModel->getStandardButton('fa fa-th', Yii::t('traits','Grid'), ['index'], [ 'class' => 'btn btn-mini' ], 'pull-left text-center') ?>

	</div>

    <div class="col-md-6">

        <a class="btn btn-default" role="button" data-toggle="collapse" href="#collapseMedia" aria-expanded="false" aria-controls="collapseMedia">
		    <?= Yii::t('media','Add Media') ?>
        </a>

	    <?= $searchModel->getResetButton() ?>

	    <?= $searchModel->getDeleteButton() ?>

	    <?= $searchModel->getUpdateButton() ?>

	    <?= $searchModel->getCreateButton() ?>

    </div>

</div>
