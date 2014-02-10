<?php

class m000000_006000_create_configuration_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'{{configuration}}',
			array(
				'id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',

				'config_key' => 'VARCHAR(100) NOT NULL',

				'value' => 'TEXT NULL DEFAULT NULL',
				'description' => 'VARCHAR(250) NULL DEFAULT NULL',
				'type' => 'TINYINT(1) UNSIGNED NULL DEFAULT NULL',

				'preload' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0',

				'visible' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not visible; 1 - visible"',
				'published' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not published; 1 - published"',
				'position' => 'INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "order by position DESC"',
				'created' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - creation time"',
				'modified' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - last entity modified time"',

				'UNIQUE KEY (config_key)',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function down()
	{
		$this->dropTable('{{configuration}}');
	}
}
