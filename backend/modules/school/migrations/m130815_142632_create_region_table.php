<?php

class m130815_142632_create_region_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable(
			'{{region}}',
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'country_id' => 'INT UNSIGNED NOT NULL COMMENT "Страна"',
				'label' => 'VARCHAR(60) NULL DEFAULT NULL COMMENT "Область"',
				'INDEX key_country_id (country_id)',
				'CONSTRAINT fk_region_country_id_to_country_id FOREIGN KEY (country_id) REFERENCES {{country}} (id) ON DELETE RESTRICT ON UPDATE RESTRICT',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function safeDown()
	{
		$this->dropTable('{{region}}');
	}
}
