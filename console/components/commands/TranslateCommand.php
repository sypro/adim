<?php
/**
 * Author: metalguardian
 * Email: metalguardian
 */

namespace console\components\commands;

use CDbConnection;
use CException;
use core\components\DbMessageSource;
use DirectoryIterator;
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

	protected $directories = array(
		'frontend.messages',
	);

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
		foreach ($this->directories as $path) {
			if ($path) {
				$path = Yii::getPathOfAlias($path);
				$this->actionPath($path);
			}
		}
	}

	/**
	 * Scan directory for languages directories with translation files
	 *
	 * @param $path
	 */
	public function actionPath($path)
	{
		/** @var DirectoryIterator[] $iterator */
		$iterator = new DirectoryIterator($path);
		foreach ($iterator as $fileInfo) {
			if (!$fileInfo->isDot() && $fileInfo->isDir()) {
				$this->actionLanguage($fileInfo->getRealPath(), $fileInfo->getFilename());
			}
		}
	}

	/**
	 * Scan one directory with translation files
	 *
	 * @param $path
	 * @param $language
	 */
	public function actionLanguage($path, $language)
	{
		/** @var DirectoryIterator[] $iterator */
		$iterator = new DirectoryIterator($path);
		foreach ($iterator as $fileInfo) {
			if ($fileInfo->isFile() && $fileInfo->getExtension() === 'php') {
				$this->actionFile($fileInfo->getRealPath(), $language, pathinfo($fileInfo->getRealPath(), PATHINFO_FILENAME));
			}
		}
	}

	/**
	 * Process one translation file
	 *
	 * @param $path
	 * @param $language
	 * @param $category
	 */
	public function actionFile($path, $language, $category)
	{
		$data = require($path);
		foreach ($data as $source => $message) {
			$sourceId = $this->sourceProcess($source, $category);
			$this->translateProcess($sourceId, $language, $message);
		}
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
			->from($this->sourceMessageTable)
			->where('BINARY category = :cat AND BINARY message = :mess', array(':cat' => $category, ':mess' => $key,))
			->queryScalar();
		if ($insertId) {
			return $insertId;
		}

		$this->getDbConnection()->createCommand()->insert(
			$this->sourceMessageTable,
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
	 * @param $id
	 * @param $language
	 * @param $translate
	 *
	 * @return bool
	 */
	public function translateProcess($id, $language, $translate)
	{
		$insertId = $this->getDbConnection()->createCommand()
			->select('id')
			->from($this->translatedMessageTable)
			->where('BINARY id = :id AND BINARY language = :lang', array(':id' => $id, ':lang' => $language, ))
			->queryScalar();
		if ($insertId) {
			return true;
		}

		$this->getDbConnection()->createCommand()->insert(
			$this->translatedMessageTable,
			array(
				'id' => $id,
				'language' => $language,
				'translation' => $translate,
			)
		);
		return true;
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

	/**
	 * @param array $directories
	 */
	public function setDirectories($directories)
	{
		$this->directories = mergeArray($this->directories, (array)$directories);
	}
}
