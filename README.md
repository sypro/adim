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
