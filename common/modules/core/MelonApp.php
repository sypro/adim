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
	 * @param string $configName
	 * @param array $mergeWith
	 *
	 * @return \CConsoleApplication|\CWebApplication
	 * @throws \Exception
	 */
	public static function create($root, $configName = 'main', $mergeWith = array())
	{
		if (($root = realpath($root)) === false) {
			throw new \Exception('could not initialize framework.');
		}
exit();
		$config = self::config($configName, $mergeWith);

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
