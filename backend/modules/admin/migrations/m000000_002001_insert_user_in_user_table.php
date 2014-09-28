<?php

use console\components\commands\ConsoleCommand;
use core\helpers\Core;

/**
 * Class m000000_002001_insert_user_in_user_table
 */
class m000000_002001_insert_user_in_user_table extends CDbMigration
{
	/**
	 * Table to the migration
	 *
	 * @var string
	 */
	public $tableName = '{{admin_user}}';

	/**
	 * commands will be executed in transaction
	 */
	public function up()
	{
		$time = time();
		$command = new ConsoleCommand();

		echo "\r\n\r\n";
		$name = $command->prompt('Admin name', 'admin');
		$email = $command->prompt('Admin email (used as login)', 'admin@melon.dev');
		$password = $command->prompt('Admin password', 'admin@melon.dev');

		$this->insert(
			$this->tableName,
			array(
				'name' => $name,
				'email' => $email,
				'password' => CPasswordHelper::hashPassword($password),
				'role' => 'admin',
				'created' => $time,
				'modified' => $time,
			)
		);
	}

	/**
	 * commands will be executed in transaction
	 */
	public function down()
	{
		$this->truncateTable($this->tableName);
	}
}
