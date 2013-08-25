<?php
$main = require(__DIR__ . '/../../common/config/main.php');
$frontend = array(
	'id'=>'front',
	'basePath' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
	'name' => 'Skooltv',
	'aliases' => array(
		'front' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
		'frontend' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'frontend'
		),
		'menu' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'menu'
		),
		'seo' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'seo'
		),
		'language' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'language'
		),
		'news' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'news'
		),
		'configuration' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'configuration'
		),
	),
	'theme' => 'melon',
	'preload' => array('maintenanceMode', ),
	'modules' => array(
		'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password' => false,
			'ipFilters' => array('127.0.0.1','::1'),
			'generatorPaths' => array(
				'frontend.components.gii',
			),
		),
		'frontend' => array(
			'class' => '\frontend\FrontendModule',
		),
		'file-processor' => array(
			'class' => '\fileProcessor\FileProcessorModule',
			'baseDir' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'www') . DIRECTORY_SEPARATOR,
			'originalBaseDir' => 'uploads',
			'cachedImagesBaseDir' => 'uploads/thumb',
			// set path without first and last slashes
			'imageSections' => array(

			),
			'imageHandler' => array(
				'driver' => '\fileProcessor\extensions\imageHandler\drivers\MDriverGD',
				// '\fileProcessor\extensions\imageHandler\drivers\MDriverImageMagic'
			),
		),
		'menu' => array(
			'class' => '\menu\MenuModule',
		),
		'news' => array(
			'class' => '\news\NewsModule',
		),
		'configuration' => array(
			'class' => '\configuration\ConfigurationModule',
		),
	),
	'controllerNamespace' => '\front\controllers',
	'controllerMap'=>array(
		'image' => array(
			'class'=>'\fileProcessor\controllers\ImageController',
		),
	),
	'components' => array(
		'themeManager' => array(
			'basePath' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'themes'),
		),
		'urlManager' => array(
			'class' => '\language\components\LanguageUrlManager',
			'defaultLanguage' => 'ru',
			'urlFormat' => 'path',
			'showScriptName' => false,
			'useStrictParsing' => true,
			'exclude' => array('gii', 'image'),
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
				array('site/index', 'pattern' => '<lang:\w{2}>'),
				array('site/index', 'pattern' => ''),

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
		'maintenanceMode' => array(
			'class' => '\MaintenanceMode',
			'enabledMode' => false,
			//'message' => 'Hello!',
			// or
			'capUrl' => '/site/maintenance',
			// allowed users
			//'users' => array('admin', ),
			// allowed roles
			//'roles' => array('Administrator', ),
			// allowed IP
			'ips' => array(),
			// allowed urls
			//'urls' => array('/site/login', '/login', ),
		),
		'user' => array(
			'class' => '\frontend\components\WebUser',
			// enable cookie-based authentication
			'allowAutoLogin' => true,
			'autoRenewCookie' => true,
			'identityCookie' => array(
				'path' => '/',
				//'domain' => '.example.com'
			),
		),
		'request' => array(
			'enableCookieValidation' => true,
			'enableCsrfValidation' => true,
			'csrfCookie' => array(
				'httpOnly'=>true,
			),
		),
		'clientScript' => array(
			'class' => '\core\components\ClientScript',
			'coreScriptPosition' => \CClientScript::POS_HEAD,
			'packages' => array(
				'front.main' => array(
					'baseUrl' => '/',
					'js' => array(
						'js/application.js',
					),
					'css' => array(
						'css/application.css' => 'screen, projection',
					),
				),
				'theme.melon' => array(
					'baseUrl' => '/themes/melon/',
					'js' => array(
					),
					'css' => array(
					),
				),
			),
			'scriptMap' => array(),
		),
		'errorHandler' => array(
			'errorAction' => 'site/error',
		),
		'session' => array(
			'class' => '\frontend\components\DbHttpSession',
			'connectionID' => 'db',
			'autoStart' => true,
			'cookieMode' => 'allow',
			'timeout' => 60*60*24*30,
			'cookieParams' => array(
				'path' => '/',
				'example' => '.example.com',
				'httpOnly' => true,
			),
			'sessionTableName' => '{{yii_session}}',
			'autoCreateSessionTable' => false,
		),
		'config' => array(
			'class' => '\configuration\components\ConfigurationComponent',
		),
		'messages' => array(
			'class' => '\frontend\components\DbMessageSource',
		),
	),
);

$localFile = __DIR__ . '/local.php';
$local = file_exists($localFile) ? require($localFile) : array();
return \CMap::mergeArray(
	\CMap::mergeArray(
		$main,
		$frontend
	),
	$local
);
