<?php

class m130815_180000_create_school_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'{{school}}',
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'label' => 'VARCHAR(150) NULL DEFAULT NULL COMMENT "Название"',
				'address' => 'TEXT NULL DEFAULT NULL COMMENT "Адерс"',
				'eaddress' => 'TEXT NULL DEFAULT NULL COMMENT "Электронный адрес"',
				'director' => 'VARCHAR(150) NULL DEFAULT NULL COMMENT "Директор"',
				'village_id' => 'INT UNSIGNED NULL DEFAULT NULL COMMENT "Город"',
				'image_id1' => 'INT UNSIGNED NULL DEFAULT NULL COMMENT "Фото"',
				'image_id2' => 'INT UNSIGNED NULL DEFAULT NULL COMMENT "Фото"',

				'visible' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1',
				'published' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1',
				'position' => 'INT UNSIGNED NOT NULL DEFAULT 0',
				'created' => 'INT UNSIGNED NOT NULL',
				'modified' => 'INT UNSIGNED NOT NULL',

				'INDEX key_village_id (village_id)',
				'CONSTRAINT fk_school_village_id_to_village_id FOREIGN KEY (village_id) REFERENCES {{village}} (id) ON DELETE RESTRICT ON UPDATE RESTRICT',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function down()
	{
		$this->dropTable('{{school}}');
	}
}
