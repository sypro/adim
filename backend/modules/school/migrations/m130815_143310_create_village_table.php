<?php

class m130815_143310_create_village_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable(
			'{{village}}',
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'area_id' => 'INT UNSIGNED NOT NULL COMMENT "Район"',
				'label' => 'VARCHAR(60) NULL DEFAULT NULL COMMENT "Город"',
				'INDEX key_area_id (area_id)',
				'CONSTRAINT fk_village_area_id_to_area_id FOREIGN KEY (area_id) REFERENCES {{area}} (id) ON DELETE RESTRICT ON UPDATE RESTRICT',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function safeDown()
	{
		$this->dropTable('{{village}}');
	}
}
