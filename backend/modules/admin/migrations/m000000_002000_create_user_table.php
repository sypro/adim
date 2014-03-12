<?php

use console\components\commands\ConsoleCommand;
use core\helpers\Core;

/**
 * Class m000000_002000_create_user_table
 */
class m000000_002000_create_user_table extends CDbMigration
{
	/**
	 * Table to the migration
	 *
	 * @var string
	 */
	public $tableName = '{{admin_user}}';

	/**
	 * commands will be executed in transaction
	 */
	public function up()
	{
		$this->createTable(
			$this->tableName,
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'name' => 'VARCHAR(75) NULL DEFAULT NULL',
				'email' => 'VARCHAR(45) NULL DEFAULT NULL',
				'role' => 'VARCHAR(20) NULL DEFAULT NULL',
				'password' => 'VARCHAR(64) NULL DEFAULT NULL',
				'visible' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not visible; 1 - visible"',
				'published' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not published; 1 - published"',
				'position' => 'INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "order by position DESC"',
				'created' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - creation time"',
				'modified' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - last entity modified time"',
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
