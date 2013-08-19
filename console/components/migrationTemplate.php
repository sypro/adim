<?php

class {ClassName} extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable(
			'{{table}}',
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

	public function safeDown()
	{

	}
}
