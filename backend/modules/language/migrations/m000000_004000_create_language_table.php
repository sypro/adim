<?php

class m000000_004000_create_language_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'{{language}}',
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',

				'label' => 'VARCHAR(20) NULL DEFAULT NULL COMMENT "language label"',
				'code' => 'VARCHAR(5) NULL DEFAULT NULL COMMENT "language code"',

				'visible' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not visible; 1 - visible"',
				'published' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not published; 1 - published"',
				'position' => 'INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "order by position DESC"',
				'created' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - creation time"',
				'modified' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - last entity modified time"',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci'
		);

		$this->insert('{{language}}', array(
			'label' => 'рус',
			'code' => 'ru',
		));
	}

	public function down()
	{
		$this->dropTable('{{language}}');
	}
}
