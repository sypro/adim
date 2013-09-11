<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core;

/**
 * Class MelonApp
 * @package core
 */
class MelonApp
{
	/**
	 * @param $root
	 *
	 * @return \CConsoleApplication|\CWebApplication
	 * @throws \Exception
	 */
	public static function create($root, $vendors)
	{
		if (($root = realpath($root)) === false) {
			throw new \Exception('could not initialize framework.');
		}

		$global = $root . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'global.php';
		require_once($global);

		$yii = realpath($vendors
			. DIRECTORY_SEPARATOR
			. 'yiisoft'
			. DIRECTORY_SEPARATOR
			. 'yii' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'yii.php');
		require_once($yii);

		$config = require_once($root . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php');

		if (php_sapi_name() !== 'cli') {
			$app = \Yii::createWebApplication($config);
		} else {
			defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
			$app = \Yii::createConsoleApplication($config);
			$app->commandRunner->addCommands($root . '/cli/commands');
			$env = @getenv('YII_CONSOLE_COMMANDS');
			if (!empty($env)) {
				$app->commandRunner->addCommands($env);
			}
		}

		return $app;
	}
}
