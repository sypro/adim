<?php

class m130815_142106_create_coutry_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable(
			'{{country}}',
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'label' => 'VARCHAR(60) NULL DEFAULT NULL COMMENT "Название"',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function safeDown()
	{
		$this->dropTable('{{country}}');
	}
}
