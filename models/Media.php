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
use getid3_exception;
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
 * @property string $createButton
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
	 * Before delete Media
	 *
	 * @throws InvalidParamException
	 */
	public function beforeDelete()
	{
		/** @var Media $this */
		$this->deleteFile();
		$this->deleteThumbs();

		return parent::beforeDelete();
	}

	/**
	 * Delete file Media
	 *
	 * @return mixed
	 * @throws InvalidParamException
	 */
	public function deleteFile()
	{
		$file = $this->mediaPath;

		if ( !empty($this->filename) && file_exists($file) ) {
			unlink($file);
		}

		return true;
	}

	public function deleteThumbs()
	{
		$thumbS  = $this->getMediaThumbsPath('small');
		$thumbM  = $this->getMediaThumbsPath('medium');
		$thumbL  = $this->getMediaThumbsPath('large');
		$thumbXL = $this->getMediaThumbsPath('extra');

		$thumbVideo = $this->getMediaThumbsPath('video') . '.jpg';

		if ( !empty($this->filename) && file_exists($thumbS) ) {
			unlink($thumbS);
		}

		if ( !empty($this->filename) && file_exists($thumbM) ) {
			unlink($thumbM);
		}

		if ( !empty($this->filename) && file_exists($thumbL) ) {
			unlink($thumbL);
		}

		if ( !empty($this->filename) && file_exists($thumbXL) ) {
			unlink($thumbXL);
		}

		if ( !empty($this->filename) && file_exists($thumbVideo) ) {
			unlink($thumbVideo);
		}

		return true;
	}

	/**
	 * Fetch stored file name with complete path
	 *
	 * @return string
	 * @throws InvalidParamException
	 */
	public function getMediaPath() {
		return Yii::getAlias(Yii::$app->getModule('media')->mediaPath).$this->filename;
	}

	/**
	 * Fetch stored thumbs filename with complete path
	 *
	 * @param string $size
	 *
	 * @return string
	 */
	public function getMediaThumbsPath($size = 'small') {
		return Yii::getAlias(Yii::$app->getModule('media')->mediaThumbsPath).'/'.$size.'/'.$this->filename;
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
		$mediaUrl = Yii::getAlias(Yii::$app->getModule('media')->mediaURL).$this->filename;

		if($default && !file_exists($mediaUrl)) {
			return Yii::getAlias(Yii::$app->getModule('media')->mediaURL).'image-not-found.jpg';
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
		$mediaThumbUrl = '';

		if (strpos($this->mimetype, 'image') !== false) {
			$mediaThumbUrl = Yii::getAlias(Yii::$app->getModule('media')->mediaThumbsURL).'/'.$size.'/'.$this->filename;
		}

		if (strpos($this->mimetype, 'video') !== false) {
			$mediaThumbUrl = Yii::getAlias(Yii::$app->getModule('media')->mediaThumbsURL).'/video/'.$this->filename.'.jpg';
		}

		if($default && !file_exists($mediaThumbUrl)) {
			return Yii::getAlias(Yii::$app->getModule('media')->mediaURL).'image-not-found.jpg';
		}

		return $mediaThumbUrl;
	}

	/**
	 * Upload file to folder
	 *
	 * @param UploadedFile $file
	 * @param string $reference
	 *
	 * @return Media | bool
	 * @throws Exception
	 * @throws getid3_exception
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
		$mediaPath = Yii::getAlias(Yii::$app->getModule('media')->mediaPath);
		// get media extension
		$mediaExt = $file->extension;
		// update file->name
		$file->name = $mediaName.".{$mediaExt}";
		// file full path
		$fileFullPath = $mediaPath.$mediaName.".{$mediaExt}";
		// save images to imagePath
		$fileUpload = $file->saveAs($fileFullPath);

		if($fileUpload) {
			$media->title = $originalName;
			$media->alias = $mediaAlias;
			$media->filename = $file->name;
			$media->originalname = $originalName;
			$media->reference = $reference;
			$media->duration = strpos($media->mimetype, 'video') !== false ? $this->getVideoDuration($fileFullPath) : null;
			$media->extension = $mediaExt;
			$media->mimetype = $file->type;
			$media->created = date('Y-m-d H:i:s');
			$media->created_by = Yii::$app->user->id;
			$media->size  = $file->size;
			$media->save();
		}

		if($media->id !== null && (strpos($media->mimetype, 'image') !== false || strpos($media->mimetype, 'video') !== false) ) {
			$this->createMediaThumbs($media);
		}

		return $media;
	}

	/**
	 * Create Media Thumbs files
	 *
	 * @param Media $media
	 *
	 * @return mixed
	 * @throws getid3_exception
	 */
	public function createMediaThumbs($media)
	{
		$mediaPath  = Yii::getAlias(Yii::$app->getModule('media')->mediaPath);
		$thumbsPath = Yii::getAlias(Yii::$app->getModule('media')->mediaThumbsPath);

		$mediaName = $media->filename;
		$mediaLink = $mediaPath.$media->filename;
		$mediaOptions = Yii::$app->getModule('media')->mediaThumbsOptions;

		// Save Image Thumbs
		if(strpos($media->mimetype, 'image') !== false) {
			Image::thumbnail($mediaLink, $mediaOptions['small']['width'], $mediaOptions['small']['height'])
				->save( $thumbsPath . 'small/' . $mediaName, [ 'quality' => $mediaOptions['small']['quality']]);
			Image::thumbnail($mediaLink, $mediaOptions['medium']['width'], $mediaOptions['medium']['height'])
				->save( $thumbsPath . 'medium/' . $mediaName, [ 'quality' => $mediaOptions['medium']['quality']]);
			Image::thumbnail($mediaLink, $mediaOptions['large']['width'], $mediaOptions['large']['height'])
				->save( $thumbsPath . 'large/' . $mediaName, [ 'quality' => $mediaOptions['large']['quality']]);
			Image::thumbnail($mediaLink, $mediaOptions['extra']['width'], $mediaOptions['extra']['height'])
				->save( $thumbsPath . 'extra/' . $mediaName, [ 'quality' => $mediaOptions['extra']['quality']]);
		}

		// Save Video Thumbs
		if(strpos($media->mimetype, 'video') !== false) {
			$frame = $this->getVideoThumb($mediaLink,$sec = 3);
			$frame->save($thumbsPath . 'video/' .$media->filename.'.jpg');
		}

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
		return Yii::$app->getModule('media')->mediaType;
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
	 * Generate Attachment type from mimetype
	 *
	 * @return string[]
	 */
	public function getMediaType()
	{
		return $this->getAttachmentType();
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
		$html .= '<img src="'.$media->getMediaThumbsUrl('small').'" alt="'.$attributes['title'].'" title="'.$attributes['title'].'">';
		if (strpos($media->mimetype, 'video') !== false) {
			$html .= '<span style="color: #FFF; position:absolute; left: 47%; top: 30%;"><i class="fa fa-play" aria-hidden="true"></i></span>';
		}
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
				'initialPreview' => false,
				'initialPreviewAsData' => false,
				'overwriteInitial' => true
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
     * @inheritdoc
     *
     * @return MediaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MediaQuery(static::class);
    }

}
