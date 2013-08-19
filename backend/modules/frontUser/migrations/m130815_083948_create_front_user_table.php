<?php

class m130815_083948_create_front_user_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'{{table}}',
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',

				'label' => 'VARCHAR(200) NULL DEFAULT NULL COMMENT "Заголовок"',

				'visible' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "Видимость"',
				'published' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "Опубликовано"',
				'position' => 'INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Позиция"',
				'created' => 'INT UNSIGNED NOT NULL COMMENT "Создано"',
				'modified' => 'INT UNSIGNED NOT NULL COMMENT "Изменено"',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci'
		);
	}

	public function down()
	{
		$this->dropTable('{{table}}');
	}
}
