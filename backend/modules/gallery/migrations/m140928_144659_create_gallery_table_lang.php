<?php

/**
 * Class m140928_144659_create_gallery_table_lang
 */
class m140928_144659_create_gallery_table_lang extends \CDbMigration
{
	/**
	 * migration related table name
	 */
	public $tableName = '{{gallery_lang}}';

	/**
	 * main table name, to make constraints
	 */
	public $relatedTableName = '{{gallery}}';

	/**
	 * commands will be executed in transaction
	 */
	public function safeUp()
	{
		$this->createTable(
			$this->tableName,
			array(
				'l_id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'model_id' => 'INT UNSIGNED NOT NULL',
				'lang_id' => 'VARCHAR(5) NULL DEFAULT NULL',

				// examples:
				'l_label' => 'VARCHAR(200) NULL DEFAULT NULL',
				//'l_announce' => 'TEXT NULL DEFAULT NULL',
				//'l_content' => 'TEXT NULL DEFAULT NULL',

				'INDEX key_model_id_lang_id (model_id, lang_id)',
				'INDEX key_model_id (model_id)',
				'INDEX key_lang_id (lang_id)',

				'CONSTRAINT fk_gallery_lang_model_id_to_main_model_id FOREIGN KEY (model_id) REFERENCES ' . $this->relatedTableName . ' (id) ON DELETE CASCADE ON UPDATE CASCADE',
				'CONSTRAINT fk_gallery_lang_lang_id_to_language_id FOREIGN KEY (lang_id) REFERENCES {{language}} (code) ON DELETE RESTRICT ON UPDATE CASCADE',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	/**
	 * commands will be executed in transaction
	 */
	public function safeDown()
	{
		$this->dropTable($this->tableName);
	}
}
