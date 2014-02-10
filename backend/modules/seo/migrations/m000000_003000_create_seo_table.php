<?php

class m000000_003000_create_seo_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'{{seo}}',
			array(
				'model_name' => 'VARCHAR(100) NOT NULL',
				'model_id' => 'INT UNSIGNED NOT NULL',
				'lang_id' => 'VARCHAR(5) NOT NULL',

				'title' => 'TEXT NULL DEFAULT NULL',
				'keywords' => 'TEXT NULL DEFAULT NULL',
				'description' => 'TEXT NULL DEFAULT NULL',

				'visible' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not visible; 1 - visible"',
				'published' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not published; 1 - published"',
				'position' => 'INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "order by position DESC"',
				'created' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - creation time"',
				'modified' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - last entity modified time"',

				'PRIMARY KEY (model_name,model_id,lang_id)',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function down()
	{
		$this->dropTable('{{seo}}');
	}
}
