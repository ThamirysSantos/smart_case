up:
	docker-compose up -d --build

down:
	docker-compose down

install:
	docker-compose exec app composer install
	docker-compose exec app php artisan key:generate

optimize:
	docker-compose exec app php artisan optimize
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan config:cache
	docker-compose exec app php artisan  config:clear
