<?php

/**
 * Class m141029_232928_create_table_slider
 */
class m141029_232928_create_table_slider extends \CDbMigration
{
	/**
	 * migration related table name
	 */
	public $tableName = '{{slider}}';

	/**
	 * commands will be executed in transaction
	 */
	public function safeUp()
	{
		$this->createTable(
			$this->tableName,
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',

                'image_id' => 'INT UNSIGNED NULL',

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
		$this->dropTable($this->tableName);
	}
}
