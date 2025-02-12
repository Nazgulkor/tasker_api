# tasker_api
# Установка нужных вещей
# Установите на машину docker https://www.docker.com/
# и Make https://www.gnu.org/software/make/
## Подготовка окружения

Скопируйте файл `./src/.env.example` в `./src/.env`

Скопируйте файл `.env.example` в `.env` и добавьте в него следующие строки:
<strong> <br>
MYSQL_DATABASE=tasker<br>
MYSQL_USER=root<br>
MYSQL_ROOT_PASSWORD=root<br>
MYSQL_PASSWORD=root<br>
</strong>

#  И пропишите в консоли команду <i>Make install</i>

