# docker compose in development
build_dev:
	docker compose -f local.yml up --build

dev:
	docker compose -f local.yml up

dev_down:
	docker compose -f local.yml down

migrate:
	docker compose -f local.yml run --rm worker php artisan migrate

seed:
	docker compose -f local.yml run --rm worker php artisan db:seed

test:
	docker compose -f local.yml run --rm worker php artisan test
