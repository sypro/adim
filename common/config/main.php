<?php

$main = array(
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'timeZone' => 'Europe/Kiev',
	'name' => 'Melon Application',
	'preload' => array('log'),
	'aliases' => array(
		'vendor'  => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor'),
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
			'defaultLanguage' => 'ru',
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
			'connectionString' => 'mysql:host=localhost;dbname=vintageua_melon',
			'emulatePrepare' => true,
			'tablePrefix' => 'sktv_',
			'username' => 'vintageua_melon',
			'password' => 'CWvdBXH2RVWqGJBL',
			'charset' => 'utf8',
			'schemaCachingDuration' => 0,
			'enableProfiling' => true,
			'enableParamLogging' => true,
		),
		'errorHandler' => array(
			'class' => '\core\components\ErrorHandler',
		),
		'log' => array(
			'class' => '\CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				array(
					'class' => '\YiiDebugToolbarRoute',
					// Access is restricted by default to the localhost
					'ipFilters' => array('127.0.0.1', ),
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
