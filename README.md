# Melon Engine

------------
# Установка

1. Клонировать репозиторий (`git clone git@bitbucket.org:vintageua/melon.git`)
2. Удалить ветку `origin`, которая ссылается на репозиторий каркаса (`git remote rm origin`)
3. Добавить ветку `origin`, которая будет ссылаться на новый репозиторий (`git remote add origin git@bitbucket.org:user/repo.git`)
4. Отправить все комиты в новый репозиторий: `git push -u origin --all` и `git push -u origin --tags`
5. Скопировать файл `common/config/local.php.sample` в `common/config/local.php` и настроить в нем подключение к базе данных (и другие настройки при необходимости)
6. Скопировать файл `console/config/local.php.sample` в `console/config/local.php`. Это добавит дополнительный функционал: уберёт запрос на выполнение миграций (`'interactive' => false,`), дополнительные команды, и т.д.
7. Запустить команду `composer install` (если composer установлен как бинарник, если нет [смотри тут](#markdown-header-composer-install))

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

в composer использовать только для install, update использовать только если добавился какой то дополнительный репозиторий

-------------------
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

ОБЯЗАТЕЛЬНО использовать связи! прописывать их в создании таблицы или отдельно, но не забывать про них. пример:

```
CONSTRAINT fk_menu_menu_id_to_menu_list_id FOREIGN KEY (menu_id) REFERENCES {{menu_list}} (id) ON DELETE RESTRICT ON UPDATE RESTRICT
```

--------------------------------------
# Требования к оформлению и именованию

* весь sql код писать КАПСОМ

* для числовых полей, которые не могут быть отрицательными (индексы, каунтеры) должны быть UNSIGNED

* indexes in the last rows

* устанавливать движок и кодировку: `ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci`

* поля по умолчанию (могут отсутствовать некоторые поля в зависимости от потребностей таблицы):

	1. `published` - опубликованность записи, если не опубликована, то ее нельзя увидеть нигде

	2. `visible` - видимость записи, то есть она может быть опубликована и не видна в списках, но доступна по ссылке

	3. `position` - сортировка записей

	4. `created` - `time()` создания записи

	5. `modified` - `time()` изменения записи

* именование полей по умолчанию:

	1. `label` для заголовка объекта

	2. `alias` для ссылки объекта

	3. `content` для контентной части объекта

	4. `announce` для короткого описания объекта

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

Команда запрашивает ввод названия таблицы, с которой будут происходить изменения в миграции

```
./yiic migrate create create_table_name

Yii Migration Tool v1.0 (based on Yii v1.1.15-dev)

Active database component (connectionString):
    mysql:host=localhost;dbname=database


Migration table name (without prefix): table_name
New migration created successfully.
```

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

# Create admin module

создаем через gii модуль. прописываем его в конфиге (aliases и modules)

```
'aliases' => array(
	...
	'moduleName' => realpath(
		__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'moduleName'
	),
	...
),
'modules' => array(
	...
	'moduleName' => array(
		'class' => '\moduleName\ModuleNameModule',
	),
	...
),

```

добавляем модуль в список модулей для команды миграции:

```
'commandMap' => array(
	...
	'migrate' => array(
		...
		'modulePaths' => array(
			...
			'backModuleName' => 'back.modules.moduleName.migrations',
			...
		),
	),
),
```

создаем из консоли миграцию с `./yiic migrate create backModuleName create_table_name`,
задаем структуру таблицы, выполняем миграции `./yiic migrate`

создаем через gii модель. располагаем ее в модуле. меняем правила валидации, настройки формы, настройки вывода.

создаем через gii crud (в текущей реализации это один контроллер). располагаем его в модуле.

меню админпанели задается просто в виджете `/backend/modules/menu/widgets/MenuWidget.php`

# Multi language

В модуле Языки добавляем необходимые языки. Код должен соответствовать стандартным кодам языка
(алисы сейчас не предусмотрены) для нормальной поддержки языка фреймворком

Язык по умолчанию объявляется в компоненте `urlManager` `/common/config/main.php`. параметр `defaultLanguage`.

Поля формы и просмотра объекта автоматически геренируются для всех языков приложения.

Gii генерирует как главную модель с готовыми поведениями, так и зависимую модель. Все зависит от галочек выбраных в генераторе.

Для создания миграции для мультиязычной модели необходимо добавить параметр `--lang` при создании миграции.
Этот параметр создаст сразу две миграции: основная модель и зависимая, языковая.

```
./yiic migrate create migration_name --lang
```

Название зависимой таблицы строго определено - добавлением суфикса `_lang` к имени основной таблицы: main_table_lang.

В миграции представлены стандартные поля языковой таблицы, которые нельзя менять:

```
'l_id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
'model_id' => 'INT UNSIGNED NOT NULL',
'lang_id' => 'VARCHAR(5) NULL DEFAULT NULL',

'INDEX key_model_id_lang_id (model_id, lang_id)',
'INDEX key_model_id (model_id)',
'INDEX key_lang_id (lang_id)',

'CONSTRAINT fk_language_model_model_id_to_main_model_id FOREIGN KEY (model_id) REFERENCES ' . $this->relatedTableName . ' (id) ON DELETE CASCADE ON UPDATE CASCADE',
'CONSTRAINT fk_language_model_lang_id_to_language_id FOREIGN KEY (lang_id) REFERENCES {{language}} (code) ON DELETE RESTRICT ON UPDATE RESTRICT',
```

Языковые поля, которые будут переводиться должны быть именованы по принципу - префикс `l_`, например, `l_content`

В gii необходимо сгенерировать главнуб модель (выбрав параметр: Multi language model) и зависимую (выбрав параметр: Language model)

В основной моделе заполнить массив локализированых параметров:

```
public static function getLocalizedAttributesList()
{
	return array('localized_value1', 'localized_value2', );
}
```

Этого достаточно для использования мультиязычности на сайте. Главное правильно генерировать модели. Все остальное работает по умолчанию.

# Front config


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


