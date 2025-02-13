# tasker_api
## Требования к окружению
1. Установлен [docker](https://www.docker.com/) и [docker-compose](https://docs.docker.com/compose/install/)
2. Установлен [Make](https://www.gnu.org/software/make/)

## Установка приложения
1. Создание конфигов:
`cp .env.example .env && cp src/.env.example src/.env`

2. Установка приложения:
`make install`

## Инструменты разработки
### Установка ide_helper
```php artisan ide-helper:generate``` [PHPDoc generation for Laravel Facades](https://github.com/barryvdh/laravel-ide-helper#automatic-phpdoc-generation-for-laravel-facades)
```php artisan ide-helper:meta``` [PhpStorm Meta file](https://github.com/barryvdh/laravel-ide-helper#phpstorm-meta-for-container-instances)
```php artisan ide-helper:models``` [PHPDocs for models](https://github.com/barryvdh/laravel-ide-helper#automatic-phpdocs-for-models)

### Генерация API документации
```php artisan l5-swagger:generate```

после чего документация доступна по ссылке [API Docs](http://localhost/api/documentation)