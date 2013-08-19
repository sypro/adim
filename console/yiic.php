<?php
/**
 * Yii command line script file.
 *
 * This script is meant to be run on command line to execute
 * one of the pre-defined console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

// change the following paths if necessary
$yii = __DIR__ . '/../common/extensions/yii/framework/yii.php';
$config = __DIR__ . '/config/main.php';

// fix for fcgi
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once($yii);

// define namespace for yii correct work
\Yii::setPathOfAlias(
	'core',
	__DIR__ . DIRECTORY_SEPARATOR . '..'
	. DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'core'
);

$app = Yii::createConsoleApplication($config);
$app->commandRunner->addCommands(YII_PATH . '/cli/commands');

$env = @getenv('YII_CONSOLE_COMMANDS');
if (!empty($env)) {
	$app->commandRunner->addCommands($env);
}

$app->run();
