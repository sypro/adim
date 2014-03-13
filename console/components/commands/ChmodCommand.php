<?php
/**
 *
 */
namespace console\components\commands;

use CConsoleCommand;
use CException;
use Yii;

/**
 * Class ChmodCommand
 *
 * @package console\components\commands
 */
class ChmodCommand extends CConsoleCommand
{
	/**
	 * Run all chmod commands in one action
	 */
	public function actionSystem()
	{
		$this->actionRuntime();
		$this->actionAsset();
	}

	/**
	 * Set permissions to all runtime folders
	 * in backend, frontend, console
	 */
	public function actionRuntime()
	{
		$paths = array(
			Yii::getPathOfAlias('console') . DIRECTORY_SEPARATOR . 'runtime',
			Yii::getPathOfAlias('front') . DIRECTORY_SEPARATOR . 'runtime',
			Yii::getPathOfAlias('back') . DIRECTORY_SEPARATOR . 'runtime',
		);
		foreach ($paths as $path) {
			$this->actionChmod($path);
		}
	}

	/**
	 * @param string $path
	 * @param int $mode an octal number
	 *
	 * @throws CException
	 * @return bool
	 */
	public function actionChmod($path)
	{
		$realPath = realpath($path);
		if ($realPath !== false) {
			if (is_writable($realPath)) {
				// TODO: may cause error when owner is other user and permission is 0777 already
				if (chmod($realPath, 0777)) {
					$error = strtr('Set permission [777] to the [{path}].', array('{path}' => h($path), ));
					echo PHP_EOL . $error . PHP_EOL;
					return true;
				}
			}
		}
		$error = strtr('File or directory [{path}] does not exist or permission denied.', array('{path}' => h($path), ));
		throw new CException($error);
	}

	/**
	 * Set permissions to all assets folders
	 * in backend, frontend
	 */
	public function actionAsset()
	{
		$paths = array(
			Yii::getPathOfAlias('front') . DIRECTORY_SEPARATOR . 'www' . DIRECTORY_SEPARATOR . 'assets',
			Yii::getPathOfAlias('back') . DIRECTORY_SEPARATOR . 'www' . DIRECTORY_SEPARATOR . 'assets',
		);
		foreach ($paths as $path) {
			$this->actionChmod($path);
		}
	}
}
