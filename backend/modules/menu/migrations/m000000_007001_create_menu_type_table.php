<?php

class m000000_007001_create_menu_type_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'{{menu_type}}',
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',

				'label' => 'VARCHAR(200) NULL DEFAULT NULL COMMENT "entity label"',
				'model_name' => 'VARCHAR(200) NULL DEFAULT NULL',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci'
		);
		$this->insert('{{menu_type}}', array(
			'id' => 1,
			'label' => 'Ссылка',
			'model_name' => '\menu\models\Link',
		));
	}

	public function down()
	{
		$this->dropTable('{{menu_type}}');
	}
}
