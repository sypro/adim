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
			// псевдоним директории, в которую распаковано расширение
			'class' => '\EMigrateCommand',
			// путь для хранения общих миграций
			'migrationPath' => 'console.migrations',
			// имя таблицы с версиями
			'migrationTable' => '{{yii_migration}}',
			// имя псевдомодуля для общих миграций. По умолчанию равно "core".
			'applicationModuleName' => 'core',
			// определяем все модули, для которых нужны миграции  (в противном случае, модули будут взяты из конфигурации Yii)
			'modulePaths' => array(
				'backUser' => 'back.modules.user.migrations',
				'backSeo' => 'back.modules.seo.migrations',
				'backLanguage' => 'back.modules.language.migrations',
				'backTranslate' => 'back.modules.translate.migrations',
				'backConf' => 'back.modules.configuration.migrations',
				'backMenu' => 'back.modules.menu.migrations',
				'fileProcessor' => 'webroot.vendor.metalguardian.yii-file-processor.fileProcessor.migrations'
			),
			// можно задать имя поддиректории для хранения миграций в директории модуля
			'migrationSubPath' => 'migrations',
			// отключаем некоторые модули
//			'disabledModules' => array(
//				'admin', 'anOtherModule', // ...
//			),
			// название компонента для подключения к базе данных
			'connectionID'=>'db',
			// алиас шаблона для новых миграций
			'templateFile'=>'application.components.migrationTemplate',
		),
//		'migrate' => array(
//			'class' => 'system.cli.commands.MigrateCommand',
//			'migrationPath' => 'application.migrations',
//			'migrationTable' => '{{yii_migration}}',
//			'connectionID' => 'db',
//			'interactive' => false,
//			'templateFile' => 'application.components.migrationTemplate',
//		),
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
