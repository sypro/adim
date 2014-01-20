<?php
$main = require(__DIR__ . '/../../common/config/main.php');
unset($main['controllerMap']);
unset($main['controllerNamespace']);
unset($main['theme']);

$console = array(
	'name' => 'Melon Console Application',
	'aliases' => array(
		'console' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
		'back' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'backend'),
		'front' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'frontend'),
	),
	'basePath' => realpath(__DIR__ . DIRECTORY_SEPARATOR .  '..'),
	'commandMap' => array(
		'migrate' => array(
			'class' => '\console\commands\MigrateCommand',
			'migrationPath' => 'application.migrations',
			'migrationTable' => '{{yii_migration}}',
			'connectionID' => 'db',
			'interactive' => false,
			'templateFile' => 'application.components.migrationTemplate',
			'applicationModuleName' => 'core',
			'modulePaths' => array(
				'backUser' => 'back.modules.user.migrations',
				'backSeo' => 'back.modules.seo.migrations',
				'backLanguage' => 'back.modules.language.migrations',
				'backTranslate' => 'back.modules.translate.migrations',
				'backConf' => 'back.modules.configuration.migrations',
				'backMenu' => 'back.modules.menu.migrations',
				'fileProcessor' => 'root.vendor.metalguardian.yii-file-processor.fileProcessor.migrations'
			),
			'migrationSubPath' => 'migrations',
			'disabledModules' => array(
				//'admin',
			),
		),
	),
	'params' => array(
		'composer.callbacks' => array(
			'post-update' => array(
				array(
					'yiic',
					'migrate',
				),
			),
			'post-install' => array(
				array(
					'yiic',
					'migrate',
				),
			),
		),
	),
);

$localFile = __DIR__ . '/local.php';
$local = file_exists($localFile) ? require($localFile) : array();
return \mergeArray(
	\mergeArray(
		$main,
		$console
	),
	$local
);
