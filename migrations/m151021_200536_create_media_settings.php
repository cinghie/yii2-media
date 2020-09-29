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

/**
 * Class m151021_200536_create_media_settings
 */
class m151021_200536_create_media_settings extends Migration
{
	/**
	 * @inheritdoc
	 */
    public function up()
    {
	    $datetime = date('Y-m-d H:i:s');

	    $this->insert('{{%settings}}', [
		    'key' => 'tinifyActive', 'value' => 0, 'section' => 'MediaSettings', 'type' => 'integer',
		    'active' => 1, 'created' => $datetime, 'modified' => $datetime,
	    ]);

	    $this->insert('{{%settings}}', [
		    'key' => 'tinifyAutomatic', 'value' => 0, 'section' => 'MediaSettings', 'type' => 'integer',
		    'active' => 1, 'created' => $datetime, 'modified' => $datetime,
	    ]);

	    $this->insert('{{%settings}}', [
		    'key' => 'tinifyCode', 'value' => '', 'section' => 'MediaSettings', 'type' => 'string',
		    'active' => 1, 'created' => $datetime, 'modified' => $datetime,
	    ]);
    }

	/**
	 * @inheritdoc
	 */
    public function down()
    {
	    $this->delete('{{%settings}}', ['key' => 'tinifyActive']);
	    $this->delete('{{%settings}}', ['key' => 'tinifyAutomatic']);
	    $this->delete('{{%settings}}', ['key' => 'tinifyCode']);
    }
}
