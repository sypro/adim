<?php

/**
 * Class m140928_141030_create_gallery_table
 */
class m140928_141030_create_gallery_table extends \CDbMigration
{
	/**
	 * migration related table name
	 */
	public $tableName = '{{gallery}}';

	/**
	 * commands will be executed in transaction
	 */
	public function safeUp()
	{
		$this->createTable(
			$this->tableName,
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',

				'label' => 'VARCHAR(200) NULL DEFAULT NULL COMMENT "Заголовок"',

				'visible' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1',
				'published' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1',
				'position' => 'INT UNSIGNED NOT NULL DEFAULT 0',
				'created' => 'INT UNSIGNED NOT NULL',
				'modified' => 'INT UNSIGNED NOT NULL',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	/**
	 * commands will be executed in transaction
	 */
	public function safeDown()
	{
		/*
		uncomment if you need to drop table or delete this lines
		$this->dropTable($this->tableName);
		*/
	}
}
