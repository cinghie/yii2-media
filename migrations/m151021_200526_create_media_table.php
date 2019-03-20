<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-media
 * @license BSD-3-Clause
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
            'alias' => $this->string(255)->defaultValue(null),
            'filename' => $this->string(255)->notNull(),
            'originalname' => $this->string(255)->notNull(),
            'reference' => $this->string(32),
            'extension' => $this->string(12)->notNull(),
            'mimetype' => $this->string(255)->notNull(),
            'duration' => $this->string(32)->defaultValue(null),
            'size' => $this->integer(32)->notNull(),
            'tinified' => $this->integer(32)->defaultValue(null),
            'created_by' => $this->integer(11)->defaultValue(null),
            'created' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
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
