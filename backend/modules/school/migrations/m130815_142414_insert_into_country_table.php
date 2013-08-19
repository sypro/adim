<?php

class m130815_142414_insert_into_country_table extends CDbMigration
{
	public function safeUp()
	{
		$counties = require_once(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'country.php'));
		foreach ($counties as $data) {
			$this->insert('{{country}}', $data);
		}
	}

	public function safeDown()
	{
		$this->truncateTable('{{country}}');
	}
}
