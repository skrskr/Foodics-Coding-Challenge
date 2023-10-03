# Foodics Coding Challenge

## Requirements
- PHP 8.2
- Laravel 10
- Mysql 8
- Redis 7

## Installation
- 1. Clone Repo from github
```bash
git clone https://github.com/skrskr/Foodics-Coding-Challenge.git
```
- 2. create `.env` file
```bash
cp .env.example .env
```
- 3. update `.env` variables
```
# Database
DB_HOST=db
DB_PORT=3306
DB_DATABASE=ingredient_db
DB_USERNAME=root
DB_PASSWORD=password

# Redis
QUEUE_CONNECTION=redis
REDIS_HOST=redis
REDIS_CLIENT=predis

# Mail Server
MAIL_HOST=mailhog

# Merchant Email
MERCHANT_EMAIL="merchant@foodics.com"
```

- 4. Up and run project using docker
```bash
# Using make 
make dev
# docker command
# docker compose -f local.yml up
```
- The project will up and running on port `8000` http://localhost:8000
- The mailhog service will be up and running on port `8025` http://localhost:8025

- 5. Migrate database
```bash
# Using make 
make migrate
# docker command
# docker compose -f local.yml run --rm app php artisan migrate
```

- 6. Seeding data in database
```bash
# Using make 
make seed
# docker command
# docker compose -f local.yml run --rm app php artisan db:seed
```

- 7. Creating order using `curl` command line
```bash
curl -X POST -H "Content-Type: application/json" -d '{"products":[{"product_id": 1, "quantity": 1}]}' http://localhost:8000/api/v1/orders
```