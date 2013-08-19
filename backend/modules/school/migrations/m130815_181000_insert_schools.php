<?php

class m130815_181000_insert_schools extends CDbMigration
{
	public function safeUp()
	{
		$schools = require_once(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'school.php'));
		foreach ($schools as $data) {
			$this->insert('{{school}}', $data);
		}
	}

	public function down()
	{
		$this->truncateTable('{{school}}');
	}
}
