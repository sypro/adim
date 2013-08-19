<?php

class m000000_006001_create_configuration_lang_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'{{configuration_lang}}',
			array(
				'l_id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'model_id' => 'VARCHAR(100) NOT NULL',
				'lang_id' => 'VARCHAR(6) NULL DEFAULT NULL',

				'l_value' => 'TEXT NULL DEFAULT NULL',

				'INDEX key_model_id_lang_id (model_id, lang_id)',
				'INDEX key_model_id (model_id)',
				'INDEX key_lang_id (lang_id)',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci'
		);
	}

	public function down()
	{
		$this->dropTable('{{configuration_lang}}');
	}
}
