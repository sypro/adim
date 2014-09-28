<?php

/**
 * Class m000000_005002_create_message_missing_table
 */
class m000000_005002_create_message_missing_table extends CDbMigration
{
	/**
	 * migration related table name
	 */
	public $tableName = '{{message_missing}}';

	/**
	 * commands will be executed in transaction
	 */
	public function safeUp()
	{
		$this->createTable(
			$this->tableName,
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',

				'application_id' => 'VARCHAR(32) NOT NULL DEFAULT "" COMMENT "Ид приложения"',

				'message' => 'TEXT NOT NULL DEFAULT "" COMMENT "Оригинал"',
				'category' => 'VARCHAR(32) NOT NULL DEFAULT "" COMMENT "Категория"',
				'language' => 'VARCHAR(5) NOT NULL DEFAULT "" COMMENT "Язык"',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	/**
	 * commands will be executed in transaction
	 */
	public function safeDown()
	{
		$this->dropTable($this->tableName);
	}
}
