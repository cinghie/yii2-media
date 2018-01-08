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
 */
class Media extends \yii\db\ActiveRecord
{

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
            'id' => Yii::t('app', 'ID'),
            'reference' => Yii::t('app', 'Reference'),
            'title' => Yii::t('app', 'Title'),
            'alias' => Yii::t('app', 'Alias'),
            'filename' => Yii::t('app', 'Filename'),
            'extension' => Yii::t('app', 'Extension'),
            'mimetype' => Yii::t('app', 'Mimetype'),
            'size' => Yii::t('app', 'Size'),
            'hits' => Yii::t('app', 'Hits'),
        ];
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
