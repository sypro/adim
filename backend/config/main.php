<?php
$main = require(__DIR__ . '/../../common/config/main.php');
$backend = array(
	'id' => 'melon-backend',
	'basePath' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
	'timeZone' => 'Europe/Kiev',
	/*'name' => '{application-name}',*/
	'aliases' => array(
		'backend' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
		'back' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'back'
		),
		'admin' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'admin'
		),
		'menu' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'menu'
		),
		'elfinder' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'elfinder'
		),
		'seo' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'seo'
		),
		'language' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'language'
		),
		'translate' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'translate'
		),
		'configuration' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'configuration'
		),
		'emailQueue' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'emailQueue'
		),
	),
	'preload' => array('bootstrap',),
	'import' => array(),
	'modules' => array(
		'back' => array(
			'class' => '\back\BackModule',
		),
		'admin' => array(
			'class' => '\admin\AdminModule',
		),
		'menu' => array(
			'class' => '\menu\MenuModule',
		),
		'file-processor' => array(
			'class' => '\fileProcessor\FileProcessorModule',
			'baseDir' => realpath(
					__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'www'
				) . DIRECTORY_SEPARATOR,
			'originalBaseDir' => 'uploads',
			'cachedImagesBaseDir' => 'uploads/thumb',
			// set path without first and last slashes
			'imageSections' => array(
				'admin' => array(
					'index' => array(
						'width' => 100,
						'height' => 100,
						'quality' => 70,
						'do' => 'resize', // resize|adaptiveResize
					),
					'view' => array(
						'width' => 300,
						'height' => 300,
						'quality' => 90,
						'do' => 'resize', // resize|adaptiveResize
					),
					'form' => array(
						'width' => 300,
						'height' => 300,
						'quality' => 90,
						'do' => 'resize', // resize|adaptiveResize
					),
				),
			),
			'imageHandler' => array(
				'driver' => '\fileProcessor\extensions\imageHandler\drivers\MDriverGD',
				// '\fileProcessor\extensions\imageHandler\drivers\MDriverImageMagic'
			),
		),
		'elfinder' => array(
			'class' => '\elfinder\ElfinderModule',
		),
		'seo' => array(
			'class' => '\seo\SeoModule',
		),
		'language' => array(
			'class' => '\language\LanguageModule',
		),
		'translate' => array(
			'class' => '\translate\TranslateModule',
		),
		'configuration' => array(
			'class' => '\configuration\ConfigurationModule',
		),
		'emailQueue' => array(
			'class' => '\emailQueue\EmailQueueModule',
		),
	),
	'controllerNamespace' => '\backend\controllers',
	'controllerMap' => array(
		'image' => array(
			'class' => '\fileProcessor\controllers\ImageController',
		),
	),
	'components' => array(
		'bootstrap' => array(
			'class' => '\back\components\Bootstrap',
			'responsiveCss' => true,
		),
		'format' => array(
			'class' => '\back\components\Formatter',
		),
		'user' => array(
			'class' => '\admin\components\WebUser',
		),
		'authManager' => array(
			'class' => '\admin\components\PhpAuthManager',
			'defaultRoles' => array('guest',),
		),
		'session' => array(
			'class' => '\CDbHttpSession',
			'connectionID' => 'db',
			'autoStart' => true,
			'cookieMode' => 'allow',
			'timeout' => 60 * 60 * 24 * 30,
			'cookieParams' => array(
				'path' => '/',
				//'example' => '.example.com',
				'httpOnly' => true,
			),
			'sessionTableName' => '{{yii_session}}',
			'autoCreateSessionTable' => false,
		),
		'urlManager' => array(
			'class' => '\core\components\UrlManager',
			'urlFormat' => 'path',
			'showScriptName' => false,
			'rules' => array(
				/*array(
					'route1',
					'pattern' => 'pattern1',
					'urlSuffix' => '.xml',
					'caseSensitive' => false | true,
					'defaultParams' => array(
						'param1' => 'value1',
					),
					'matchValue' => false | true | null,
					'verb' => 'POST,GET,DELETE' | null,
					'parsingOnly' => false | true,
				),*/
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
				array(
					'class' => '\fileProcessor\components\YiiFileProcessorUrlRule',
					'connectionId' => 'db',
					'cacheId' => 'cache',
					'controllerId' => 'image',
				),
				// gii
				array('gii', 'pattern' => 'gii'),
				array('gii/<controller>', 'pattern' => 'gii/<controller:\w+>'),
				array('gii/<controller>/<action>', 'pattern' => 'gii/<controller:\w+>/<action:\w+>'),
			),
		),
		'request' => array(
			'enableCookieValidation' => true,
		),
		'clientScript' => array(
			'class' => '\core\components\ClientScript',
			'packages' => array(
				'backend.main' => array(
					'baseUrl' => '/',
					'js' => array(
						'js/form.helpers.js',
						'js/application.js',
					),
					'css' => array(
						'css/application.css' => 'screen, projection',
					),
					'depends' => array('jquery',),
				),
			),
			'scriptMap' => array(),
		),
	),
);
$localFile = __DIR__ . '/local.php';
$local = file_exists($localFile) ? require($localFile) : array();
return \mergeArray(
	\mergeArray(
		$main,
		$backend
	),
	$local
);
