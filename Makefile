up:
	docker-compose up -d --build

down:
	docker-compose down

generate-key:
	docker-compose exec app php artisan key:generate

optimize:
	docker-compose exec app php artisan optimize
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan config:cache
	docker-compose exec app php artisan  config:clear

migrate-reset:
	docker-compose exec app php artisan migrate:reset

migrate:
	docker-compose exec app php artisan migrate

seed:
	docker-compose exec app php artisan db:seed

setup:
	make up
	make generate-key
	make optimize
	make migrate
