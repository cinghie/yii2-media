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
use yii\db\ActiveRecord;

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
	 * Get Upload Widget
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
