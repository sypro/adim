<?php

class m130815_143251_create_area_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable(
			'{{area}}',
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'region_id' => 'INT UNSIGNED NOT NULL COMMENT "Область"',
				'label' => 'VARCHAR(60) NULL DEFAULT NULL COMMENT "Район"',
				'INDEX key_region_id (region_id)',
				'CONSTRAINT fk_area_region_id_to_region_id FOREIGN KEY (region_id) REFERENCES {{region}} (id) ON DELETE RESTRICT ON UPDATE RESTRICT',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function safeDown()
	{
		$this->dropTable('{{area}}');
	}
}
