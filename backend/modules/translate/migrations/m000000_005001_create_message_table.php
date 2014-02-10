<?php

class m000000_005001_create_message_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'{{message}}',
			array(
				'id' => 'INT',
				'language' => 'VARCHAR(16)',
				'translation' => 'TEXT',
				'PRIMARY KEY (id, language)',
				'CONSTRAINT fk_message_source_message FOREIGN KEY (id) REFERENCES {{source_message}} (id) ON DELETE CASCADE ON UPDATE RESTRICT',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function down()
	{
		$this->dropTable('{{message}}');
	}
}
