<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
if (YII_DEBUG) {
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL|E_STRICT);

	// specify how many levels of call stack should be shown in each log message
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 4);
	//show profiler
	defined('YII_DEBUG_SHOW_PROFILER') or define('YII_DEBUG_SHOW_PROFILER', true);
	//enable profiling
	defined('YII_DEBUG_PROFILING') or define('YII_DEBUG_PROFILING', true);
	//execution time
	defined('YII_DEBUG_DISPLAY_TIME') or define('YII_DEBUG_DISPLAY_TIME', true);
}

// change the following paths if necessary
$yii = __DIR__ . '/../../common/extensions/yii/framework/yii.php';
$config = __DIR__ . '/../config/main.php';
$global = __DIR__ . '/../../common/extensions/global.php';

require_once($yii);
require_once($global);

// define namespace for yii correct work
\Yii::setPathOfAlias(
	'core',
	__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..'
	. DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'core'
);

\Yii::createApplication('\core\components\WebApplication', $config)->run();
