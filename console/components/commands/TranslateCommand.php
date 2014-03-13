<?php
/**
 * Author: metalguardian
 * Email: metalguardian
 */

namespace console\components\commands;

use CDbConnection;
use CException;
use core\components\DbMessageSource;
use Yii;

/**
 * Class TranslateCommand
 *
 * @package console\components\commands
 */
class TranslateCommand extends \CConsoleCommand
{
	/**
	 * @var string the name of the source message table. Defaults to 'SourceMessage'.
	 */
	public $sourceMessageTable;

	/**
	 * @var string the name of the translated message table. Defaults to 'Message'.
	 */
	public $translatedMessageTable;

	/**
	 * @var string the ID of the database connection application component. Defaults to 'db'.
	 */
	public $connectionId;

	/**
	 * Db connection
	 *
	 * @var
	 */
	private $db;

	public function init()
	{
		parent::init();

		if (!$this->sourceMessageTable || !$this->translatedMessageTable || !$this->connectionId) {
			/** @var DbMessageSource $messages */
			$messages = Yii::app()->getMessages();
			$this->connectionId = $messages->connectionID;
			$this->translatedMessageTable = $messages->translatedMessageTable;
			$this->sourceMessageTable = $messages->sourceMessageTable;
		}
	}

	public function actionIndex()
	{
	}

	/**
	 * @param $key
	 *
	 * @param string $category
	 *
	 * @return string
	 */
	public function sourceProcess($key, $category = 'core')
	{
		$insertId = $this->getDbConnection()->createCommand()
			->select('id')
			->from('{{source_message}}')
			->where('category = :cat AND message = :mess', array(':cat' => $category, ':mess' => $key,))
			->queryScalar();
		if ($insertId) {
			return $insertId;
		}

		$this->getDbConnection()->createCommand()->insert(
			'{{source_message}}',
			array(
				'id' => null,
				'category' => $category,
				'message' => $key,
			)
		);
		$insertId = $this->getDbConnection()->getLastInsertID();

		return $insertId;
	}

	/**
	 * Returns the DB connection used for the message source.
	 *
	 * @throws CException if {@link connectionID} application component is invalid
	 * @return CDbConnection the DB connection used for the message source.
	 */
	public function getDbConnection()
	{
		if ($this->db === null) {
			$this->db = Yii::app()->getComponent($this->connectionId);
			if (!$this->db instanceof CDbConnection) {
				$error = strtr(
					'TranslateCommand.connectionId is invalid. Please make sure "{id}" refers to a valid database application component.',
					array('{id}' => $this->connectionId)
				);
				throw new CException($error);
			}
		}

		return $this->db;
	}
}
