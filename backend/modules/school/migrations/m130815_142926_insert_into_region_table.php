<?php

class m130815_142926_insert_into_region_table extends CDbMigration
{
	public function safeUp()
	{
		$region = require_once(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'region.php'));
		foreach ($region as $data) {
			$this->insert('{{region}}', $data);
		}
	}

	public function safeDown()
	{
		$this->truncateTable('{{region}}');
	}
}
