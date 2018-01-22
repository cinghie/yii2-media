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
use cinghie\traits\TitleAliasTrait;
use cinghie\traits\ViewsHelpersTrait;

/**
 * This is the model class for table "{{%media}}".
 *
 * @property int $id
 * @property string $reference
 * @property string $title
 * @property string $alias
 * @property string $filename
 * @property string $extension
 * @property string $mimetype
 * @property int $size
 * @property int $hits
 *
 * @property Media $items
 */
class Media extends \yii\db\ActiveRecord
{
	use AttachmentTrait, TitleAliasTrait, ViewsHelpersTrait;

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
        return [
            [['reference', 'title', 'alias', 'filename', 'extension', 'mimetype', 'size'], 'required'],
            [['size', 'hits'], 'integer'],
            [['reference'], 'string', 'max' => 32],
            [['title', 'alias', 'filename', 'mimetype'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('media', 'ID'),
            'reference' => Yii::t('media', 'Reference'),
            'title' => Yii::t('media', 'Title'),
            'alias' => Yii::t('media', 'Alias'),
            'filename' => Yii::t('media', 'Filename'),
            'extension' => Yii::t('media', 'Extension'),
            'mimetype' => Yii::t('media', 'Mimetype'),
            'size' => Yii::t('media', 'Size'),
            'hits' => Yii::t('media', 'Hits'),
        ];
    }

	/**
	 * Get Upload Widget
	 *
	 *
	 */
    public function getUploadsWidget()
    {
		return;
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
