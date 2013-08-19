<?php

$main = array(
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'timeZone' => 'Europe/Kiev',
	'name' => 'Melon Application',
	'preload' => array('log'),
	'aliases' => array(
		'root' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..'),
		'common' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR),
	),
	'import' => array(),
	'modules' => array(
		'core' => array(
			'class' => '\core\CoreModule',
		),
	),
	'components' => array(
		'urlManager' => array(
			'class' => '\core\components\UrlManager',
			'defaultLanguage' => 'uk',
		),
		'cache'=>array(
			'class'=>'system.caching.CDummyCache',
		),
		'assetManager' => array(
			'excludeFiles' => array(
				'.svn',
				'.git',
			),
		),
		'db' => array(
			'class' => '\core\components\DbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=skooltv',
			'emulatePrepare' => true,
			'tablePrefix' => 'sktv_',
			'username' => 'skooltv',
			'password' => 'PVBANL5u33260-v',
			'charset' => 'utf8',
			'schemaCachingDuration' => 0,
			'enableProfiling' => true,
			'enableParamLogging' => true,
		),
		'errorHandler' => array(
			'class' => '\core\components\ErrorHandler',
		),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				array(
					'class'=>'common.extensions.yii-debug-toolbar.yii-debug-toolbar.YiiDebugToolbarRoute',
					// Access is restricted by default to the localhost
					'ipFilters'=>array('127.0.0.1'),
				),
			),
		),
	),
	'sourceLanguage' => 'no',
	'language' => 'ru',
	'params' => array(
	),
);

$localFile = __DIR__ . '/local.php';
$local = file_exists($localFile) ? require($localFile) : array();
return \CMap::mergeArray(
	$main,
	$local
);
