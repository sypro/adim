<?php

/**
 * Class m000000_003000_create_seo_table
 */
class m000000_003000_create_seo_table extends CDbMigration
{
	/**
	 * migration related table name
	 */
	public $tableName = '{{seo}}';

	/**
	 * commands will be executed in transaction
	 */
	public function up()
	{
		$this->createTable(
			$this->tableName,
			array(
				'model_name' => 'VARCHAR(100) NOT NULL',
				'model_id' => 'INT UNSIGNED NOT NULL',
				'lang_id' => 'VARCHAR(5) NOT NULL',

				'title' => 'TEXT NULL DEFAULT NULL',
				'keywords' => 'TEXT NULL DEFAULT NULL',
				'description' => 'TEXT NULL DEFAULT NULL',

				'created' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - creation time"',
				'modified' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - last entity modified time"',

				'PRIMARY KEY (model_name, model_id, lang_id)',
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
