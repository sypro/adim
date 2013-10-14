# Melon Engine

# Migration commands
```
./yiic migrate
./yiic migrate --migrationPath=back.modules.user.migrations
./yiic migrate --migrationPath=back.modules.seo.migrations
./yiic migrate --migrationPath=back.modules.language.migrations
./yiic migrate --migrationPath=back.modules.translate.migrations
./yiic migrate --migrationPath=back.modules.configuration.migrations
./yiic migrate --migrationPath=back.modules.menu.migrations
./yiic migrate --migrationPath=common.extensions.yii-file-processor.migrations
```

# Installation

после клонирования запустить:
```
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

конфиги:
сейчас в репозитории настройки для дев сервера.
что бы переопределить что то: нужно создавать файлы `local.php` в папках конфигурации. (можно создать сразу в `common` и переопределить сразу для всего)

настройка хостов:
2 домена должны ссылаться на `/backend/www` и `/frontend/www`

настройка загрузки файлов:
создать папку uploads (можно поменять в конфиге) в `/frontend/www/`, доступы 777
прописать символьную линку для доступа из бекенда:
```
ln -s /path/to/frontend/www/uploads/ /path/to/backend/www/
```

логин и пароль на админку в миграции задаются `/backend/modules/user/migrations/m130528_114049_create_user_table.php`

запустить все миграции описанные выше (по ходу работы добавлять в этот список новые миграции и сабмодули)

работа с базой ТОЛЬКО через миграции. все данные, которые попадают в базу тоже должны быть в миграциях. можно делать дампы и вызывать их, но не копаться в структуре и данных руками

# Create admin module

создаем через gii модуль. прописываем его в конфиге (aliases и modules)

создаем из консоли миграцию с `migrationPath` в новый модуль, выполняем миграцию

создаем через gii модель. располагаем ее в модуле. меняем правила валидации, настройки формы, настрофки вывода.

создаем через gii crud (в текущей реализации это один контроллер). располагаем его в модуле.

меню админпанели задается просто в виджете `/backend/modules/menu/widgets/MenuWidget.php`


# Multilangual model

В модуле Языки добавляем необходимые языки. Код должен соответствовать стандартным кодам языка (алисы сейчас не предусмотрены) для нормальной поддержки языка фреймворком

Язык по умолчанию объявляется в компоненте `urlManager` (пока так) `/common/config/main.php`. параметр `defaultLanguage`.

Поля формы и просмотра объекта автоматически геренируются для всех языков приложения.

Gii генерирует как главную модель с готовыми поведениями, так и зависимую модель. Все зависит от галочек выбраных в генераторе.

пример миграции зависимой языковой таблицы:

```
class m131014_102113_create_content_lang_table extends CDbMigration
{
	public $tableName = '{{content_lang}}';
	public function safeUp()
	{
		$this->createTable(
			$this->tableName,
			array(
				'l_id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'model_id' => 'INT UNSIGNED NOT NULL',
				'lang_id' => 'VARCHAR(6) NULL DEFAULT NULL',

				'l_label' => 'VARCHAR(200) NULL DEFAULT NULL',
				'l_announce' => 'TEXT NULL DEFAULT NULL',
				'l_content' => 'TEXT NULL DEFAULT NULL',

				'INDEX key_model_id_lang_id (model_id, lang_id)',
				'INDEX key_model_id (model_id)',
				'INDEX key_lang_id (lang_id)',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	public function safeDown()
	{
		$this->dropTable($this->tableName);
	}
}
```

# Front config

конфиг для фронтеэнда

```
'theme' => 'arredo',
'components' => array(
	...
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
				'depends' => array('jquery', ),
			),
			'theme.melon' => array(
				'baseUrl' => '/themes/melon/',
				'js' => array(
					'js/plugins.js',
					'js/functions.js',
				),
				'css' => array(
					'css/style.css' => 'screen, projection',
				),
				'depends' => array('jquery', ),
			),
		),
		'scriptMap' => array(),
	),
	...
),
```

вызывать клиент скрипт так:

```
cs()->registerPackage('theme.melon');
cs()->registerPackage('front.main');
```
