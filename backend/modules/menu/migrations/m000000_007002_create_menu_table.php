<?php

class m000000_007002_create_menu_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'{{menu}}',
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',

				'menu_id' => 'INT UNSIGNED NULL DEFAULT NULL',

				'label' => 'VARCHAR(200) NULL DEFAULT NULL COMMENT "entity label"',
				'parent_id' => 'INT UNSIGNED NULL DEFAULT NULL',

				'type_id' => 'INT UNSIGNED NULL DEFAULT NULL',
				'related_id' => 'INT UNSIGNED NULL DEFAULT NULL',

				'link' => 'VARCHAR(250) NULL DEFAULT NULL',

				'visible' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not visible; 1 - visible"',
				'published' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 - not published; 1 - published"',
				'position' => 'INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "order by position DESC"',
				'created' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - creation time"',
				'modified' => 'INT UNSIGNED NOT NULL COMMENT "unix timestamp - last entity modified time"',

				'CONSTRAINT fk_menu_menu_id_to_menu_list_id FOREIGN KEY (menu_id) REFERENCES {{menu_list}} (id) ON DELETE RESTRICT ON UPDATE RESTRICT',
				'CONSTRAINT fk_menu_parent_id_to_menu_id FOREIGN KEY (parent_id) REFERENCES {{menu}} (id) ON DELETE RESTRICT ON UPDATE RESTRICT',
				'CONSTRAINT fk_menu_type_to_menu_type_id FOREIGN KEY (type_id) REFERENCES {{menu_type}} (id) ON DELETE RESTRICT ON UPDATE RESTRICT',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci'
		);
	}

	public function down()
	{
		$this->dropTable('{{menu}}');
	}
}
