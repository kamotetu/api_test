up:
	docker-compose up -d
up-build:
	docker-compose up -d --build
down:
	docker-compose down
ssh:
	docker-compose exec -u www-data php bash

build:
	docker-compose build

build--no-cache:
	docker-compose build --no-cache
up-S:
	php -S localhost:8080
unittest:
	vendor/phpunit/phpunit/phpunit tests