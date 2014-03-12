<?php
/**
 *
 */
namespace console\components\commands;

use CConsoleCommand;
use Yii;

/**
 * Class ChmodCommand
 *
 * @package console\components\commands
 */
class ChmodCommand extends CConsoleCommand
{
	public function actionRuntime($path = null, $mode = 0700)
	{
		if ($path === null) {
			//Yii::getPathOfAlias('console')
		} else {
			$realPath = realpath($path);
			if ($realPath !== false) {
				if (chmod($realPath, $mode)) {

				} else {

				}
			}
		}
	}

	public function actionAsset()
	{

	}
}
