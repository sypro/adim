<?php

class m000000_001000_create_yii_session_table extends CDbMigration
{
	public function up()
	{
		$this->createTable(
			'{{yii_session}}',
			array(
				'id' => 'CHAR(32) PRIMARY KEY',
				'expire' => 'INTEGER',
				'data' => 'BLOB',
				'INDEX key_expire (expire)',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function down()
	{
		$this->dropTable('{{yii_session}}');
	}
}
