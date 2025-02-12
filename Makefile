.PHONY: install

install:
	@echo "Запускаю окружение..."
	docker-compose up -d
	@echo "Устанавливаю зависимости..."
	docker exec -it tasker_app composer install
	@echo "Накатываю миграции..."
	docker exec -it tasker_app php artisan migrate
	docker exec -it tasker_app php artisan create-roles
