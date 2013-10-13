<?php
$main = require(__DIR__ . '/../../common/config/main.php');
$backend = array(
	'id' => 'melon-backend',
	'basePath' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
	'timeZone' => 'Europe/Kiev',
	'name' => 'Skooltv',
	'aliases' => array(
		'back' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
		'backstage' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'backstage'
		),
		'user' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'user'
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
		'frontUser' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'frontUser'
		),
	),
	'preload' => array('bootstrap', ),
	'import' => array(),
	'modules' => array(
		'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password' => false,
			'ipFilters' => array('127.0.0.1','::1'),
			'generatorPaths' => array(
				'backstage.components.gii',
				'bootstrap.gii',
			),
		),
		'backstage' => array(
			'class' => '\backstage\BackstageModule',
		),
		'user' => array(
			'class' => '\user\UserModule',
		),
		'menu' => array(
			'class' => '\menu\MenuModule',
		),
		'file-processor' => array(
			'class' => '\fileProcessor\FileProcessorModule',
			'baseDir' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'www') . DIRECTORY_SEPARATOR,
			'originalBaseDir' => 'uploads',
			'cachedImagesBaseDir' => 'uploads/thumb',
			// set path without first and last slashes
			'imageSections' => array(
				'admin' => array(
					'index' => array(
						'width' => 100,
						'height' => 100,
						'quality' => 70,
						'do' => 'thumb', // resize|thumb|adaptiveThumb
					),
					'view' => array(
						'width' => 300,
						'height' => 300,
						'quality' => 90,
						'do' => 'thumb', // resize|thumb|adaptiveThumb
					),
					'form' => array(
						'width' => 300,
						'height' => 300,
						'quality' => 90,
						'do' => 'thumb', // resize|thumb|adaptiveThumb
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
		'frontUser' => array(
			'class' => '\frontUser\FrontUserModule',
		),
	),
	'controllerNamespace' => '\back\controllers',
	'controllerMap'=>array(
		'image' => array(
			'class'=>'\fileProcessor\controllers\ImageController',
		),
	),
	'components' => array(
		'bootstrap' => array(
			'class' => '\Bootstrap',
			'responsiveCss' => true,
		),
		'format' => array(
			'class' => '\backstage\components\Formatter',
		),
		'user' => array(
			'class' => '\user\components\WebUser',
		),
		'authManager' => array(
			'class' => '\user\components\PhpAuthManager',
			'defaultRoles' => array('guest', ),
		),
		'session' => array(
			'class' => '\CDbHttpSession',
			'connectionID' => 'db',
			'autoStart' => true,
			'cookieMode' => 'allow',
			'timeout' => 60*60*24*30,
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
			'coreScriptPosition' => \CClientScript::POS_HEAD,
			'packages' => array(
				'back.main' => array(
					'baseUrl' => '/',
					'js' => array(
						'js/application.js',
					),
					'css' => array(
						'css/application.css' => 'screen, projection',
					),
					'depends' => array('jquery', ),
				),
			),
			'scriptMap' => array(),
		),
	),
);
$localFile = __DIR__ . '/local.php';
$local = file_exists($localFile) ? require($localFile) : array();
return \CMap::mergeArray(
	\CMap::mergeArray(
		$main,
		$backend
	),
	$local
);
