<?php

class m130815_133256_insert_into_files extends CDbMigration
{
	public function safeUp()
	{
		$files = require_once(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'files.php'));
		foreach ($files as $data) {
			$this->insert('{{file}}', $data);
		}
	}

	public function down()
	{
		$this->truncateTable('{{file}}');
	}
}
