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

namespace vendor\cinghie\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Media]].
 *
 * @see Media
 */
class MediaQuery extends ActiveQuery
{

    /**
     * @inheritdoc
     *
     * @param int $limit
     * @param string $order
     * @param string $orderby
     *
     * @return MediaQuery
     */
    public function last($limit, $orderby = "id", $order = "DESC")
    {
        return $this->orderBy([$orderby => $order])->limit($limit);
    }

    /**
     * @inheritdoc
     *
     * @return Media[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     *
     * @return Media|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
