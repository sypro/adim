<?php

class m000000_005000_create_source_message_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'{{source_message}}',
			array(
				'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
				'category' => 'VARCHAR(32)',
				'message' => 'TEXT',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function down()
	{
		$this->dropTable('{{source_message}}');
	}
}
