<?php

/**
 * Class m140928_144630_create_partners_table
 */
class m140928_144630_create_partners_table extends \CDbMigration
{
	/**
	 * migration related table name
	 */
	public $tableName = '{{partners}}';

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
                'link' => 'VARCHAR(200) NULL DEFAULT NULL COMMENT "Link to site"',
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
