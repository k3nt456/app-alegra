# Incluye las variables de docker/.env
include .env
export

setup:
	@make build
	@make up
	@make composer-update
	@make key

build:
	docker-compose build --no-cache --force-rm

stop:
	docker-compose stop

up:
	docker-compose up -d

composer-update:
	docker exec $(PROJECT_NAME)_laravel bash -c "composer update"

key:
	docker exec $(PROJECT_NAME)_laravel bash -c "php artisan key:generate"

data:
	docker exec $(PROJECT_NAME)_laravel bash -c "php artisan migrate"
	docker exec $(PROJECT_NAME)_laravel bash -c "php artisan db:seed"

access:
	docker exec -it $(PROJECT_NAME)_laravel bash
