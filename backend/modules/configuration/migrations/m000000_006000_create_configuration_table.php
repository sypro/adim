<?php

/**
 * Class m000000_006000_create_configuration_table
 */
class m000000_006000_create_configuration_table extends CDbMigration
{
	/**
	 * migration related table name
	 */
	public $tableName = '{{configuration}}';

	/**
	 * commands will be executed in transaction
	 */
	public function up()
	{
		$this->createTable(
			$this->tableName,
			array(
				'id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',

				'config_key' => 'VARCHAR(100) NOT NULL',

				'value' => 'TEXT NULL DEFAULT NULL',
				'description' => 'VARCHAR(250) NULL DEFAULT NULL',
				'type' => 'TINYINT(1) UNSIGNED NULL DEFAULT NULL',

				'preload' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0',

				'created' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - creation time"',
				'modified' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - last entity modified time"',

				'UNIQUE KEY (config_key)',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	/**
	 * commands will be executed in transaction
	 */
	public function down()
	{
		$this->dropTable($this->tableName);
	}
}
