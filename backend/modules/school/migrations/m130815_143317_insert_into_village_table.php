<?php

class m130815_143317_insert_into_village_table extends CDbMigration
{
	public function safeUp()
	{
		$village = require_once(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'village.php'));
		foreach ($village as $data) {
			$this->insert('{{village}}', $data);
		}
	}

	public function safeDown()
	{
		$this->truncateTable('{{village}}');
	}
}
