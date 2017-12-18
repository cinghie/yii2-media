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

use cinghie\traits\migrations\Migration;

class m151021_200526_create_media_table extends Migration
{

	/**
	 * @inheritdoc
	 */
    public function up()
    {
        $this->createTable('{{%media}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'alias' => $this->string(255)->notNull(),
            'filename' => $this->string(255)->notNull(),
            'extension' => $this->string(12)->notNull(),
            'mimetype' => $this->string(255)->notNull(),
            'reference' => $this->string(32)->notNull(),
            'size' => $this->integer(32)->notNull(),
            'hits' => $this->integer(11)->notNull()->defaultValue(0),
        ], $this->tableOptions);
    }

	/**
	 * @inheritdoc
	 */
    public function down()
    {
        $this->dropTable('{{%media}}');
    }

}
