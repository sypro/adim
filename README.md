# Melon Engine

# Required submodules
```
git submodule add git://github.com/yiisoft/yii.git common/extensions/yii
git submodule add git://github.com/MetalGuardian/YiiBooster.git backend/extensions/bootstrap
git submodule add git://github.com/malyshev/yii-debug-toolbar.git common/extensions/yii-debug-toolbar
git submodule add git://github.com/MetalGuardian/yii-date-time-picker.git common/extensions/date-time-picker
git submodule add git://github.com/MetalGuardian/yii-file-processor.git common/extensions/yii-file-processor
git submodule add git://github.com/karagodin/MaintenanceMode.git frontend/extensions/maintenance-mode
```

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
git submodule update --init --recursive
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
