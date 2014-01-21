<?php

class m000000_010000_create_email_queue_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable(
			'{{email_queue}}',
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',

				'subject' => 'VARCHAR(300) NULL DEFAULT NULL',
				'to' => 'VARCHAR(500) NULL DEFAULT NULL',
				'body' => 'TEXT NULL DEFAULT NULL',

				'type' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0',
				'errors' => 'INT UNSIGNED NOT NULL DEFAULT 0',
				'last_attempt' => 'INT UNSIGNED NOT NULL DEFAULT 0',
				'status' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0',
				'last_error' => 'VARCHAR(500) NULL DEFAULT NULL',

				'created' => 'INT UNSIGNED NOT NULL',
				'modified' => 'INT UNSIGNED NOT NULL',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function safeDown()
	{
		$this->dropTable('{{email_queue}}');
	}
}
