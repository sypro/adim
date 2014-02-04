# Melon Engine

------------
# Установка

1. Клонировать репозиторий (`git clone git@bitbucket.org:vintageua/melon.git`)
2. Удалить ветку `origin`, которая ссылается на репозиторий каркаса (`git remote rm origin`)
3. Добавить ветку `origin`, которая будет ссылаться на новый репозиторий (`git remote add origin git@bitbucket.org:user/repo.git`)
4. Скопировать файл `common/config/local.php.sample` в `common/config/local.php` и настроить в нем подключение к базе данных (и другие настройки при необходимости)
5. Скопировать файл `console/config/local.php.sample` в `console/config/local.php`. Это добавит дополнительный функционал: уберёт запрос на выполнение миграций (`'interactive' => false,`), дополнительные команды, и т.д.
6. Запустить команду `composer install` (если composer установлен как бинарник, если нет [смотри тут](#markdown-header-composer-install))

Получение новых комитов (`git pull`), все миграции будут выполняться автоматически при `composer update`, то есть для развертнывания проекта нужно выполнять только одну команду `composer update`

--------------------
# Composer install

что бы установить `composer` в текущий проект:
```
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```
что бы установить `composer` как бинарник - один для всей системы:
```
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```
[подробнее о composer](https://getcomposer.org)

# Настрофка проекта

## Конфиги
Конфиги наследуются и включают в себя все предыдущие уровни. Порядок включения конфигов:

1 `common/config/main.php`

2 `common/config/local.php`

3 `(frontend|backend|console|...)/config/main.php`

4 `(frontend|backend|console|...)/config/local.php`


в основных конфигурационных файлах не указано подключение к базе данных, это нужно сделать для каждого рабочего окружения отдельно

если необходимо на локальной машине использовать какой то другой компонент, модуль или настройки,
нужно переопределить это в файлах `local.php` в папках конфигурации каждого из приложений
эти файлы не попадают в репозиторий и их изменения не повлияют на работу других окружений (дев, продакшен)

## Настройка доменов

Для работы приложения необходимы 2 домена: для сайта и его административной части.
2 домена должны ссылаться на `/frontend/www` и `/backend/www` соответственно.
(Например `example.com` и `admin.example.com`)

## Настройка загрузки файлов
по умолчанию (меняется в конфигах модуля загрузки файлов) все файлы загружаются в папку `uploads`
необходимо поставить доступы 777 на этот каталог и прописать символьную линку для доступа из бекенда:
```
ln -s /path/to/frontend/www/uploads/ /path/to/backend/www/
```
это необходимо из-за того, что разделены сайт и админ части.

## Настройка входа в админку

логин и пароль на админку задаются в миграции `/backend/modules/admin/migrations/m130528_114049_create_user_table.php`

Работа с базой ТОЛЬКО через миграции. все данные, которые попадают в базу тоже должны быть в миграциях.
Можно делать дампы и вызывать их, но не копаться в структуре и данных руками.


---------------------
# Migration commands

Выполнить все миграции:

```
./yiic migrate
```

Создания новой миграции:

```
./yiic migrate create moduleName create_user_table
```

Обычное использование
```
./yiic migrate create create_user_table
```
создаёт общую миграцию (в псевдомодуле core - используеться для миграций не относящихся к какому-либо модулю)

### Параметр --module

Во всех остальных командах (`up`, `down`, `history`, `new`, `to` и `mark`) можно использовать
параметр `--module=<moduleNames>`, где `<moduleNames>` — разделённый запятыми список имён модулей,
либо просто имя модуля. Данный параметр позволяет ограничить действие команды определёнными модулями.
Примеры:

```
./yiic migrate new --module=core
```

Покажет все общие миграции (для модуля `core`).

```
./yiic migrate up 5 --module=core,user
```

Применит пять миграций в модулях `core` и `user`. Миграции остальных модулей будут
проигнорированы.

```
./yiic migrate history --module=core,user
```

Покажет, какие миграции применены к модулям `core` и `user`.
Если не указать модуль, команда ведёт себя как та, что включена в Yii за тем исключением,
что применяется ещё и ко всем модулям.

### Добавление модуля

Просто подключите модуль в файле конфигурации `console/config/main.php` и запустите `./yiic migrate up --module=yourModule`.

### Удаление модуля

Запустите `./yiic migrate to m000000_000000 --module=yourModule`. Для этого все миграции должны реализовывать метод `down()`.

ОБЯЗАТЕЛЬНО использовать связи! прописывать их в создании таблицы или отдельно, но не забывать про них. пример:

```
CONSTRAINT fk_menu_menu_id_to_menu_list_id FOREIGN KEY (menu_id) REFERENCES {{menu_list}} (id) ON DELETE RESTRICT ON UPDATE RESTRICT
```

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

# Statuses, Types

статусы по умолчанию в моделе

```
const STATUS_NOT = 0;
const STATUS_YES = 1;
```

как добавить свои типы:

```
const TYPE_GENERAL = 1;
const TYPE_LIST = 2;

public static function getTypes()
{
	return array(
		self::TYPE_GENERAL => 'Обычная страница',
		self::TYPE_LIST => 'Для списка страниц',
	);
}

public function getType()
{
	$array = self::getTypes();
	return isset($array[$this->type]) ? $array[$this->type] : null;
}
```

# default model methods

```
public function attributeLabels()
{
	$labels = \CMap::mergeArray(
		parent::attributeLabels(),
		array(
			'announce' => 'Анонс',
			'type' => 'Тип страницы',
		)
	);
	$labels = $this->generateLocalizedAttributeLabels($labels);
	return $labels;
}

public function ordered()
{
	return $this->order('t.posted DESC');
}

public static function getLocalizedAttributesList()
{
	return array('label', 'announce', 'content', );
}
```

в моделе есть обертки почти для всех поисковых вещей, смотреть в главной моделе в common приложении


