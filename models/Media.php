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

namespace cinghie\media\models;

use Yii;
use cinghie\traits\AttachmentTrait;
use cinghie\traits\ViewsHelpersTrait;
use kartik\widgets\FileInput;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%media}}".
 *
 * @property int $id
 * @property string $reference
 * @property int $size
 * @property int $hits
 *
 * @property Media $items
 */
class Media extends ActiveRecord
{
	use AttachmentTrait, ViewsHelpersTrait;

	public $items;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%media}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(AttachmentTrait::rules(), [
            [['title', 'filename'], 'required'],
            [['hits'], 'integer'],
            [['reference'], 'string', 'max' => 32],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(AttachmentTrait::attributeLabels(),[
            'id' => Yii::t('media', 'ID'),
            'hits' => Yii::t('media', 'Hits'),
            'reference' => Yii::t('media', 'Reference'),
        ]);
    }

	/**
	 * Generate Image Form Widget
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function getMediaWidget()
	{
		/** @var $this \yii\base\Model */
		$media = '<label class="control-label" for="items-photo_name">' .Yii::t('traits','Media'). '</label>';
		$media .= FileInput::widget([
			'model' => $this,
			'attribute' => 'items',
			'name' => 'items',
			'options'=>[
				'accept' => $this->getMediaAccepted()
			],
			'pluginOptions' => [
				'allowedFileExtensions' => $this->getMediaAllowed(),
				'previewFileType' => 'image',
				'showPreview' => true,
				'showCaption' => true,
				'showRemove' => true,
				'showUpload' => false,
				'initialPreview' => $this->items ? $this->getMediaUrl() : false,
				'initialPreviewAsData' => $this->items ? true : false,
				'initialPreviewConfig' => $this->isNewRecord ? [] : [ ['url' => Url::to(['deletemedia', 'id' => $this->id])] ],
				'overwriteInitial' => $this->items ? true : false
			]
		]);

		return $media;
	}

	/**
	 * Fetch stored file name with complete path
	 *
	 * @return string
	 * @throws InvalidParamException
	 */
	public function getMediaPath() {
		return isset($this->media) ? Yii::getAlias(Yii::$app->controller->module->mediaPath).$this->media : null;
	}

	/**
	 * Fetch stored file url
	 *
	 * @return string
	 * @throws InvalidParamException
	 */
	public function getMediaUrl()
	{
		// return a default media placeholder if your source avatar is not found
		$file = isset($this->media) ? $this->media : 'default.jpg';
		return Yii::getAlias(Yii::$app->controller->module->mediaURL).$file;
	}

	/**
	 * Get Upload Max Size
	 *
	 * @return string
	 */
	public function getUploadMaxSize()
	{
		return ini_get('upload_max_filesize');
	}

	/**
	 * Get Allowed Media in Accept Format
	 *
	 * @return array
	 */
	public function getMediaAccepted()
	{
		$mediaAccept = [];
		$mediaAllowed = $this->getMediaAllowed();

		foreach ($mediaAllowed as $mediaAllowed) {
			$mediaAccept[] = 'image/'.$mediaAllowed;
		}

		return $mediaAccept;
	}

	/**
	 * Get Allowed Media
	 *
	 * @return array
	 */
	public function getMediaAllowed()
	{
		return Yii::$app->controller->module->mediaType;
	}

    /**
     * @inheritdoc
     *
     * @return MediaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MediaQuery(get_called_class());
    }

}
