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

use Exception;
use Imagine\Exception\RuntimeException;
use Yii;
use cinghie\traits\AttachmentTrait;
use cinghie\traits\CreatedTrait;
use cinghie\traits\TitleAliasTrait;
use cinghie\traits\ViewsHelpersTrait;
use kartik\widgets\FileInput;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%media}}".
 *
 * @property int $id
 * @property string $originalname
 * @property string $reference
 * @property string $duration
 * @property int $size
 * @property int $hits
 *
 * @property Media $items
 *
 * @property string $formattedSize
 * @property string $uploadMaxSize
 * @property string $mimeTypeIcon
 * @property array $mediaAllowed
 * @property string $mediaPath
 * @property string $mediaThumbsPath
 * @property string[] $mediaType
 * @property string $mediasWidget
 * @property array $mediaAccepted
 */
class Media extends ActiveRecord
{
	use AttachmentTrait, CreatedTrait, TitleAliasTrait, ViewsHelpersTrait;

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
            [['duration','reference'], 'string', 'max' => 32],
            [['originalname'], 'string', 'max' => 255],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(AttachmentTrait::attributeLabels(),[
            'id' => Yii::t('traits', 'ID'),
            'duration' => Yii::t('traits', 'Duration'),
            'originalname' => Yii::t('traits', 'Original Name'),
            'reference' => Yii::t('traits', 'Reference'),
            'hits' => Yii::t('traits', 'Hits'),
        ]);
    }

	/**
	 * Generate Mediaw Grid View
	 *
	 * @param ActiveDataProvider $dataProvider
	 *
	 * @return string
	 */
	public function getMediasGrid($dataProvider)
	{
		$medias = $dataProvider->getModels();

		$html = '';
		$html .= '<div class="row">';

		foreach ($medias as $media) {
			$html .= $this->getMediaGrid($media);
		}

		$html .= '</div>';
		$html .= '<div class="clearfix"></div>';

		return $html;
	}

	/**
	 * Generate Media Grid View
	 *
	 * @param Media $media
	 *
	 * @return string
	 */
	private function getMediaGrid($media)
	{
		$attributes = $media->attributes;

		$html  = '<div class="col-md-2 col-sm-3 col-xs-6">';
		$html .= '<div class="media-item">';
		$html .= '<a href="#" class="thumbnail">';
		$html .= '<img src="'.$media->getMediaThumbsUrl('small',true).'" alt="'.$attributes['title'].'" title="'.$attributes['title'].'">';
		$html .= '</a></div></div>';

		return $html;
	}

	/**
	 * Generate Image Form Widget
	 *
	 * @return string
	 * @throws Exception
	 */
	public function getMediasWidget()
	{
		/** @var $this Media */
		return FileInput::widget([
			'model' => $this,
			'attribute' => 'items[]',
			'name' => 'items[]',
			'language' => substr(Yii::$app->language, -2),
			'options'=>[
				'accept' => $this->getMediaAccepted(),
				'multiple' => true
			],
			'pluginOptions' => [
				'allowedFileExtensions' => $this->getMediaAllowed(),
				'previewFileType' => 'image',
				'showPreview' => true,
				'showCaption' => true,
				'showRemove' => true,
				'showUpload' => true,
				'initialPreview' => $this->items ? $this->getMediaUrl() : false,
				'initialPreviewAsData' => $this->items ? true : false,
				'initialPreviewConfig' => $this->isNewRecord ? [] : [ ['url' => Url::to(['deletemedia', 'id' => $this->id])] ],
				'overwriteInitial' => $this->items ? true : false
			]
		]);
	}

	/**
	 * Generate Image Form Widget
	 *
	 * @param string $mediaName
	 *
	 * @return string
	 * @throws Exception
	 */
	public function getMediaWidget($mediaName = 'item')
	{
		/** @var $this \yii\base\Model */
		$media = '<label class="control-label" for="items-photo_name">' .Yii::t('media','Media'). '</label>';
		$media .= FileInput::widget([
			'model' => $this,
			'attribute' => $mediaName,
			'name' => $mediaName,
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
		return Yii::getAlias(Yii::$app->controller->module->mediaPath).$this->filename;
	}

	/**
	 * Fetch stored thumbs filename with complete path
	 *
	 * @return string
	 * @throws InvalidParamException
	 */
	public function getMediaThumbsPath() {
		return Yii::getAlias(Yii::$app->controller->module->mediaThumbsPath).$this->filename;
	}

	/**
	 * Fetch stored file url
	 *
	 * @param bool $default
	 *
	 * @return string
	 */
	public function getMediaUrl($default = false)
	{
		$mediaUrl = Yii::getAlias(Yii::$app->controller->module->mediaURL).$this->filename;

		if($default && !file_exists($mediaUrl)) {
			return Yii::getAlias(Yii::$app->controller->module->mediaURL).'image-not-found.jpg';
		}

		return $mediaUrl;
	}

	/**
	 * Fetch stored file thumbs url
	 *
	 * @param string $size
	 * @param bool $default
	 *
	 * @return string
	 */
	public function getMediaThumbsUrl($size = 'small', $default = false)
	{
		$mediaThumbUrl = Yii::getAlias(Yii::$app->controller->module->mediaThumbsURL).'/'.$size.'/'.$this->filename;

		if($default && !file_exists($mediaThumbUrl)) {
			return Yii::getAlias(Yii::$app->controller->module->mediaURL).'image-not-found.jpg';
		}

		return $mediaThumbUrl;
	}

	/**
	 * Upload file to folder
	 *
	 * @param UploadedFile $file
	 * @param string $reference
	 *
	 * @return Media|bool
	 * @throws \yii\base\Exception
	 */
	public function uploadMedia($file, $reference = 'yii2-media')
	{
		// if no file was uploaded abort the upload
		if ($file === null || !$file) {
			return false;
		}

		$media = new self();

		// set originale media name
		$originalName = $file->name;
		// generate media alias
		$mediaAlias = $this->generateAlias($originalName);
		// generate a unique media name
		$mediaName = Yii::$app->security->generateRandomString(32);
		// get media path from controller
		$mediaPath = Yii::getAlias(Yii::$app->controller->module->mediaPath);
		// get media extension
		$mediaExt = $file->extension;
		// update file->name
		$file->name = $mediaName.".{$mediaExt}";
		// save images to imagePath
		$fileUpload = $file->saveAs($mediaPath.$mediaName.".{$mediaExt}");

		if($fileUpload) {
			$media->title = $originalName;
			$media->alias = $mediaAlias;
			$media->filename = $file->name;
			$media->originalname = $originalName;
			$media->reference = $reference;
			$media->extension = $mediaExt;
			$media->mimetype = $file->type;
			$media->created = date('Y-m-d H:i:s');
			$media->created_by = Yii::$app->user->id;
			$media->size  = $file->size;
			$media->save();
		}

		return $media;
	}

	/**
	 * Create Thumb Images files
	 *
	 * @param Media $media
	 *
	 * @return mixed the uploaded image instance
	 * @throws RuntimeException
	 */
	public function createThumbImages($media)
	{
		$imagePath  = Yii::getAlias(Yii::$app->controller->module->mediaPath);
		$imgOptions = Yii::$app->controller->module->mediaThumbsOptions;
		$thumbsPath = Yii::getAlias(Yii::$app->controller->module->mediaThumbsPath);

		$imageName = $media->filename;
		$imageLink = $imagePath.$media->filename;

		// Save Image Thumbs
		Image::thumbnail($imageLink, $imgOptions['small']['width'], $imgOptions['small']['height'])
		     ->save( $thumbsPath . 'small/' . $imageName, [ 'quality' => $imgOptions['small']['quality']]);
		Image::thumbnail($imageLink, $imgOptions['medium']['width'], $imgOptions['medium']['height'])
		     ->save( $thumbsPath . 'medium/' . $imageName, [ 'quality' => $imgOptions['medium']['quality']]);
		Image::thumbnail($imageLink, $imgOptions['large']['width'], $imgOptions['large']['height'])
		     ->save( $thumbsPath . 'large/' . $imageName, [ 'quality' => $imgOptions['large']['quality']]);
		Image::thumbnail($imageLink, $imgOptions['extra']['width'], $imgOptions['extra']['height'])
		     ->save( $thumbsPath . 'extra/' . $imageName, [ 'quality' => $imgOptions['extra']['quality']]);

		return true;
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
		$mediasAllowed = $this->getMediaAllowed();

		foreach ($mediasAllowed as $mediaAllowed) {
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
	 * Format size in readable size
	 *
	 * @return string
	 */
	public function getFormattedSize()
	{
		$bytes = sprintf('%u', $this->size);

		if ($bytes > 0)
		{
			$unit = (int)log($bytes, 1024);
			$units = array('B', 'KB', 'MB', 'GB');

			if (array_key_exists($unit, $units) === true)
			{
				return sprintf('%d %s', $bytes / (1024 * $unit), $units[$unit]);
			}
		}

		return $bytes;
	}

	/**
	 * Get Attachmente Type Image by Type
	 *
	 * @return string
	 */
	public function getMimeTypeIcon()
	{
		$applications = [
			'csv' => '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
			'pdf' => '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
			'plain' => '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
			'text' => '<i class="fa fa-file-text-o" aria-hidden="true"></i>',
			'vnd.ms-excel' => '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
		];

		$texts = [
			'csv' => '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
			'pdf' => '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
			'plain' => '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
			'text' => '<i class="fa fa-file-text-o" aria-hidden="true"></i>',
		];

		$types = [
			'audio' => '<i class="fa fa-file-audio-o" aria-hidden="true"></i>',
			'archive' => '<i class="fa fa-file-archive-o" aria-hidden="true"></i>',
			'image' => '<i class="fa fa-file-image-o" aria-hidden="true"></i>',
			'video' => '<i class="fa fa-file-video-o" aria-hidden="true"></i>',
		];

		$mimetype = $this->getMediaType();

		foreach($types as $type => $icon)
		{
			if (isset($mimetype[0]) && $mimetype[0] === $type) {
				return $icon.'<br>'.$this->mimetype;
			}
		}

		foreach($applications as $application => $icon)
		{
			if (isset($mimetype[1]) && $mimetype[1] === $application) {
				return $icon.'<br>'.$this->mimetype;
			}
		}

		foreach($texts as $text => $icon)
		{
			if (isset($mimetype[1]) && $mimetype[1] === $text) {
				return $icon.'<br>'.$this->mimetype;
			}
		}

		return '<i class="fa fa-file-o" aria-hidden="true"></i>'.'<br>'.$this->mimetype;
	}

	/**
	 * Generate Attachment type from mimetype
	 *
	 * @return string[]
	 */
	public function getMediaType()
	{
		return explode('/',$this->mimetype);
	}

	/**
	 * Return action create button
	 *
	 * @return string
	 */
	public function getCreateButton()
	{
		return '<div class="pull-right text-center" style="margin-right: 25px;">'.
					Html::a(
					'<i class="fa fa-plus-circle text-green"></i>',
					'#collapseMedia' ,
					[ 'class' => 'btn btn-mini', 'role' => 'button', 'data-toggle' => 'collapse', 'aria-expanded' => 'false', 'aria-controls' => 'collapseMedia' ]).'
                    <div>'.Yii::t('traits','Create').'</div>
                </div>';
	}

    /**
     * @inheritdoc
     *
     * @return MediaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MediaQuery(static::class);
    }

}
