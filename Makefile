include .env

y.PHONY: install

up:
	@echo "Запускаю окружение..."
	docker-compose up -d
composer-install:
	@echo "Устанавливаю зависимости..."
	docker exec -it tasker_app composer install
create-test-db:
	@echo "Создаю тестовую базу данных..."
	docker exec -it tasker_mysql mysql -uroot -p${MYSQL_ROOT_PASSWORD} -e "CREATE DATABASE IF NOT EXISTS ${MYSQL_DATABASE}_test;"
	docker exec -it tasker_mysql mysql -uroot -p${MYSQL_ROOT_PASSWORD} -e "GRANT ALL ON ${MYSQL_DATABASE}_test.* TO ${MYSQL_USER}@'%';"
migrate-db:
	docker exec -it tasker_app php artisan migrate
migrate-test-db:
	docker exec -it tasker_app php artisan migrate --database=mysql_test
migrate: migrate-db migrate-test-db
	@echo "Накатываю миграции..."
install: up composer-install create-test-db migrate
	docker exec -it tasker_app php artisan create-roles
	docker exec -it tasker_app php artisan key:generate
app:
	docker exec -it tasker_app bash
db:
	docker exec -it tasker_mysql sh
test:
	docker exec -it tasker_app php artisan test