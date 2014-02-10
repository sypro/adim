<?php

class m000000_007003_create_menu_lang_table extends CDbMigration
{
	/**
	 * migration related table name
	 */
	public $tableName = '{{menu_lang}}';

	/**
	 * main table name, to make constraints
	 */
	public $relatedTableName = '{{menu}}';

	public function up()
	{
		$this->createTable(
			$this->tableName,
			array(
				'l_id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'model_id' => 'INT UNSIGNED NULL DEFAULT NULL',
				'lang_id' => 'VARCHAR(5) NULL DEFAULT NULL',

				'l_label' => 'VARCHAR(200) NULL DEFAULT NULL COMMENT "entity label"',
				'l_link' => 'VARCHAR(250) NULL DEFAULT NULL',

				'INDEX key_model_id_lang_id (model_id, lang_id)',
				'INDEX key_model_id (model_id)',
				'INDEX key_lang_id (lang_id)',

				'CONSTRAINT fk_menu_lang_model_id_to_main_model_id FOREIGN KEY (model_id) REFERENCES ' . $this->relatedTableName . ' (id) ON DELETE CASCADE ON UPDATE CASCADE',
				'CONSTRAINT fk_menu_lang_lang_id_to_language_id FOREIGN KEY (lang_id) REFERENCES {{language}} (code) ON DELETE RESTRICT ON UPDATE RESTRICT',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function down()
	{
		$this->dropTable($this->tableName);
	}
}
