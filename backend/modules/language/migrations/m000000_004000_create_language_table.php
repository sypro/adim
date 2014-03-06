<?php

/**
 * Class m000000_004000_create_language_table
 */
class m000000_004000_create_language_table extends CDbMigration
{
	/**
	 * migration related table name
	 */
	public $tableName = '{{language}}';

	/**
	 * commands will be executed in transaction
	 */
	public function safeUp()
	{
		$this->createTable(
			$this->tableName,
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',

				'label' => 'VARCHAR(20) NULL DEFAULT NULL COMMENT "language label"',
				'code' => 'VARCHAR(5) NOT NULL COMMENT "language code"',
				'locale' => 'VARCHAR (5) NULL DEFAULT NULL',

				'visible' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not visible; 1 - visible"',
				'published' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not published; 1 - published"',
				'position' => 'INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "order by position DESC"',
				'created' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - creation time"',
				'modified' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - last entity modified time"',

				'UNIQUE key_unique_code (code)',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);

		$this->insert('{{language}}', array(
			'label' => 'рус',
			'code' => 'ru',
			'locale' => 'ru',
		));
	}

	/**
	 * commands will be executed in transaction
	 */
	public function safeDown()
	{
		$this->dropTable($this->tableName);
	}
}
