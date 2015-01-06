<?php
$main = require(__DIR__ . '/../../common/config/main.php');
$frontend = array(
	'id' => 'melon-frontend',
	'basePath' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
	'name' => '',
	'aliases' => array(
		'frontend' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
		'front' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'front'
		),
		'translate' => realpath(
			__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'translate'
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
	'theme' => 'adim',
	'preload' => array(),
	'modules' => array(
		'front' => array(
			'class' => '\front\FrontModule',
		),
		'file-processor' => array(
			'class' => '\fileProcessor\FileProcessorModule',
			'baseDir' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'www') . DIRECTORY_SEPARATOR,
			'originalBaseDir' => 'uploads',
			'cachedImagesBaseDir' => 'uploads/thumb',
			// set path without first and last slashes
			'imageSections' => array(
                'page' => array(
                    'index' => array(
                        'width' => 100,
                        'height' => 100,
                        'quality' => 70,
                        'do' => 'adaptiveResize', // resize|adaptiveResize
                    ),
                    'slider' => array(
                        'width' => 1200,
                        'height' => 400,
                        'quality' => 90,
                        'do' => 'adaptiveResize', // resize|adaptiveResize
                    ),
                    'principles' => array(
                        'width' => 200,
                        'height' => 200,
                        'quality' => 90,
                        'do' => 'adaptiveResize', // resize|adaptiveResize
                    ),
                    'gallery' => array(
                        'width' => 250,
                        'height' => 250,
                        'quality' => 90,
                        'do' => 'adaptiveResize', // resize|adaptiveResize
                    ),
                    'image' => array(
                        'width' => 250,
                        'height' => 250,
                        'quality' => 90,
                        'do' => 'adaptiveResize', // resize|adaptiveResize
                    ),
                    'partners' => array(
                        'width' => 210,
                        'height' => 210,
                        'quality' => 90,
                        'do' => 'adaptiveResize', // resize|adaptiveResize
                    ),
                ),
                'gallery' => array(
                    'big' => array(
                        'width' => 800,//1110,
                        'height' => 600,//708,
                        'quality' => 80,
                        'do' => 'adaptiveResize', // resize|adaptiveResize
                    ),
                    'thumbs' => array(
                        'width' => 177,
                        'height' => 125,
                        'quality' => 40,
                        'do' => 'adaptiveResize', // resize|adaptiveResize
                    ),
                ),


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
                array('site/order', 'pattern' => 'site/order'),
//pages
                array('site/about', 'pattern' => '<lang:\w{2}>/about'),
                array('site/about', 'pattern' => 'about'),
                array('site/newsite', 'pattern' => '<lang:\w{2}>/newsite'),
                array('site/newsite', 'pattern' => 'newsite'),
                array('site/gallery', 'pattern' => 'gallery/<alias>'),
                array('site/gallery', 'pattern' => '<lang:\w{2}>/gallery'),
                array('site/gallery', 'pattern' => '<lang:\w{2}>/gallery/<alias>'),
                array('site/gallery', 'pattern' => 'gallery'),
                array('site/partners', 'pattern' => '<lang:\w{2}>/partners'),
                array('site/partners', 'pattern' => 'partners'),
                array('site/principles', 'pattern' => '<lang:\w{2}>/principles'),
                array('site/principles', 'pattern' => 'principles'),
                array('site/contacts', 'pattern' => '<lang:\w{2}>/contacts'),
                array('site/contacts', 'pattern' => 'contacts'),
//pages end
                array('site/imperaviImageUpload', 'pattern' => '<lang:\w{2}>/redactor/upload/image', ),
				array('site/imperaviImageUpload', 'pattern' => 'redactor/upload/image', ),
				array('site/imperaviFileUpload', 'pattern' => '<lang:\w{2}>/redactor/upload/file', ),
				array('site/imperaviFileUpload', 'pattern' => 'redactor/upload/file', ),

				array('site/cms', 'pattern' => 'cmsmagazine56dda8314b32734acb0c402354cf7bc9.txt',),

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
		'user' => array(
			'class' => '\front\components\WebUser',
			// enable cookie-based authentication
			'allowAutoLogin' => true,
			'autoRenewCookie' => true,
			'identityCookie' => array(
				'path' => '/',
				//'domain' => '.example.com'
			),
		),
		'request' => array(
			'class' => '\front\components\HttpRequest',
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
					'depends' => array('jquery', 'theme.melon'),
				),
				'theme.melon' => array(
					'baseUrl' => '/themes/melon/',
					'js' => array(
					),
					'css' => array(
					),
					'depends' => array('jquery'),
				),
                'theme.adim' => array(
                    'baseUrl' => '/themes/adim/',
                    'js' => array(
                        'js/jquery.flexslider.js',
                        'js/bootstrap.min.js',
                        'js/scripts.js',
                        'js/watermark.min.js',
                        'js/fotorama.js',

                    ),
                    'css' => array(
                        'css/bootstrap.min.css',
                        'css/style.css' => 'screen, projection',
                        'css/flexslider.css' => 'screen, projection',
                        'css/fotorama.css',
                    ),
                    'depends' => array('jquery'),
                ),
			),
			'scriptMap' => array(),
		),
		'errorHandler' => array(
			'errorAction' => 'site/error',
		),
		'session' => array(
			'class' => '\front\components\DbHttpSession',
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
