<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core;

/**
 * Class MelonApp
 *
 * @package core
 */
class MelonApp
{
	/**
	 * @param $root
	 *
	 * @param $vendors
	 * @param bool $console
	 *
	 * @throws \Exception
	 * @return \CConsoleApplication|\CWebApplication
	 */
	public static function create($root, $vendors, $console = false)
	{
		if (($root = realpath($root)) === false) {
			throw new \Exception('could not initialize framework.');
		}

		$global = $root . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'global.php';
		require_once($global);

		$config = require($root . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php');
		if (isset($config['params']['debug']) && $config['params']['debug']) {
			/** enable error display */
			ini_set('display_errors', 1);
			ini_set('track_errors', 1);
			ini_set('error_reporting', E_ALL | E_STRICT);

			/** enable debug mode */
			defined('YII_DEBUG') or define('YII_DEBUG', true);
			/** specify how many levels of call stack should be shown in each log message */
			defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 4);
			/** show profiler */
			defined('YII_DEBUG_SHOW_PROFILER') or define('YII_DEBUG_SHOW_PROFILER', true);
			/** enable profiling */
			defined('YII_DEBUG_PROFILING') or define('YII_DEBUG_PROFILING', true);
			/** execution time */
			defined('YII_DEBUG_DISPLAY_TIME') or define('YII_DEBUG_DISPLAY_TIME', true);
		}

		$yii = realpath(
			$vendors
			. DIRECTORY_SEPARATOR
			. 'yiisoft'
			. DIRECTORY_SEPARATOR
			. 'yii' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'yii.php'
		);
		if ($yii === false) {
			return null;
		}
		require_once($yii);

		if (php_sapi_name() === 'cli' || $console) {
			/** specify std in */
			defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
			$app = \Yii::createConsoleApplication($config);
			$app->commandRunner->addCommands(
				realpath(
					$vendors
					. DIRECTORY_SEPARATOR
					. 'yiisoft'
					. DIRECTORY_SEPARATOR
					. 'yii' . DIRECTORY_SEPARATOR . 'framework' . '/cli/commands'
				)
			);
			$env = @getenv('YII_CONSOLE_COMMANDS');
			if (!empty($env)) {
				$app->commandRunner->addCommands($env);
			}
		} else {
			$app = \Yii::createWebApplication($config);
		}

		return $app;
	}
}
