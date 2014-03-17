<?php
$main = require(__DIR__ . '/../../common/config/main.php');
unset($main['controllerMap']);
unset($main['controllerNamespace']);
unset($main['theme']);

$console = array(
	'name' => 'Melon Console Application',
	'aliases' => array(
		'console' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
		'backend' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'backend'),
		'frontend' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'frontend'),
	),
	'basePath' => realpath(__DIR__ . DIRECTORY_SEPARATOR .  '..'),
	'commandMap' => array(
		'migrate' => array(
			'class' => '\console\components\commands\MigrateCommand',
			'migrationTable' => '{{yii_migration}}',
			'modulePaths' => array(
				'backAdmin' => 'backend.modules.admin.migrations',
				'backSeo' => 'backend.modules.seo.migrations',
				'backLanguage' => 'backend.modules.language.migrations',
				'backTranslate' => 'backend.modules.translate.migrations',
				'backConf' => 'backend.modules.configuration.migrations',
				'backMenu' => 'backend.modules.menu.migrations',
				'fileProcessor' => 'root.vendor.metalguardian.yii-file-processor.fileProcessor.migrations',
			),
			'migrationSubPath' => 'migrations',
			'disabledModules' => array(),
		),
		'email' => array(
			'class' => '\console\components\commands\EmailCommand',
		),
		'message' => array(
			'class' => '\console\components\commands\CoreMessageCommand',
		),
		'chmod' => array(
			'class' => '\console\components\commands\ChmodCommand',
		),
		'translate' => array(
			'class' => '\console\components\commands\TranslateCommand',
		),
	),
	'components' => array(
		'mail' => array(
			'class' => '\console\components\Mail',
			'CharSet' => 'UTF-8',
			'From' => 'noreply@domain.com',
			'FromName' => 'noreply',
			//'Mailer' => 'smtp',
			//'SMTPAuth' => true,
			//'SMTPSecure' => 'tls',
			//'Port' => 587,
			//'Username' => 'smtp.name',
			//'Password' => 'password',
			//'Host' => 'smtp.host',
		),
	),
	'params' => array(
		'composer.callbacks' => array(
			'post-update' => array(
				array(
					'yiic',
					'migrate',
				),
				array(
					'yiic',
					'chmod',
				),
			),
			'post-install' => array(
				array(
					'yiic',
					'migrate',
				),
				array(
					'yiic',
					'chmod',
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
