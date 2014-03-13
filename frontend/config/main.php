<?php
$main = require(__DIR__ . '/../../common/config/main.php');
$frontend = array(
	'id'=>'front',
	'basePath' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
	'name' => '',
	'aliases' => array(
		'frontend' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
		'front2' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'front2'
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
		'emailQueue' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'emailQueue'
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
				'front2.components.gii',
			),
		),
		'front2' => array(
			'class' => '\front2\Front2Module',
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
	'controllerNamespace' => '\frontend\controllers',
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
			'class' => '\front2\components\WebUser',
			// enable cookie-based authentication
			'allowAutoLogin' => true,
			'autoRenewCookie' => true,
			'identityCookie' => array(
				'path' => '/',
				//'domain' => '.example.com'
			),
		),
		'request' => array(
			'class' => '\front2\components\HttpRequest',
			'enableCookieValidation' => true,
			'enableCsrfValidation' => true,
			'csrfCookie' => array(
				'httpOnly' => true,
			),
			'noCsrfValidationUrls' => array(),
		),
		'clientScript' => array(
			'class' => '\core\components\ClientScript',
			'packages' => array(
				'frontend.main' => array(
					'baseUrl' => '/',
					'js' => array(
						'js/application.js',
					),
					'css' => array(
						'css/application.css' => 'screen, projection',
					),
					'depends' => array('jquery', ),
				),
				'theme.melon' => array(
					'baseUrl' => '/themes/melon/',
					'js' => array(
					),
					'css' => array(
					),
					'depends' => array('jquery', ),
				),
			),
			'scriptMap' => array(),
		),
		'errorHandler' => array(
			'errorAction' => 'site/error',
		),
		'session' => array(
			'class' => '\front2\components\DbHttpSession',
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
			'class' => '\front2\components\DbMessageSource',
		),
		'log' => array(
			'routes' => array(
				array(
					'class' => '\YiiDebugToolbarRoute',
					// Access is restricted by default to the localhost
					'ipFilters' => array('127.0.0.1', ),
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
		$frontend
	),
	$local
);
