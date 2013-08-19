<?php

class m130815_143303_insert_into_area_table extends CDbMigration
{
	public function safeUp()
	{
		$area = require_once(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'area.php'));
		foreach ($area as $data) {
			$this->insert('{{area}}', $data);
		}
	}

	public function safeDown()
	{
		$this->truncateTable('{{area}}');
	}
}
