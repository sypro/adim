<?php

class m000000_007003_create_menu_lang_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'{{menu_lang}}',
			array(
				'l_id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'model_id' => 'INT UNSIGNED NULL DEFAULT NULL',
				'lang_id' => 'VARCHAR(6) NULL DEFAULT NULL',

				'l_label' => 'VARCHAR(200) NULL DEFAULT NULL COMMENT "entity label"',
				'l_link' => 'VARCHAR(250) NULL DEFAULT NULL',

				'visible' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not visible; 1 - visible"',
				'published' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not published; 1 - published"',
				'position' => 'INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "order by position DESC"',
				'created' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - creation time"',
				'modified' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - last entity modified time"',

				'INDEX key_model_id (model_id)',
				'INDEX key_lang_id (lang_id)',
				//'CONSTRAINT fk_menu_lang_model_id_to_menu_id FOREIGN KEY (model_id) REFERENCES {{menu}} (id) ON DELETE RESTRICT ON UPDATE RESTRICT',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function down()
	{
		$this->dropTable('{{menu_lang}}');
	}
}
