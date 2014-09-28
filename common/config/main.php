<?php

$main = array(
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'timeZone' => 'Europe/Kiev',
	'name' => 'Application',
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
		'file-processor' => array(
			'class' => '\fileProcessor\FileProcessorModule',
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
			),
		),
		'format' => array(
			'class' => '\core\components\Formatter',
			'dateFormat' => 'd.m.Y',
			'timeFormat' => 'H:i:s',
			'datetimeFormat' => 'd.m.Y H:i:s',
		),
		'messages' => array(
			'class' => '\core\components\DbMessageSource',
		),
	),
	'sourceLanguage' => 'no',
	'language' => 'ru',
	'params' => array(
	),
);

$localFile = __DIR__ . '/local.php';
$local = file_exists($localFile) ? require($localFile) : array();
return \mergeArray(
	$main,
	$local
);
