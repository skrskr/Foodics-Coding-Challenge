# Foodics Coding Challenge

## Requirements
- PHP 8.2
- Laravel 10
- Mysql 8
- Redis 7

## Notes
- I will keep all quantities and amounts in grams the smallest unit and add unit with it's rate to ingredient and i will convert `amount_in_grams` to it's unit while retrieving data.
- For sending notification email once, i used flag `is_merchant_notified` by default `false` when the quantity is less than 50%, i will send email and set flag to `true`, When new ingredient quantities added and greater than 50%, i will set `is_merchant_notified` to `false` again

## Installation
- 1. Clone Repo from github
```bash
git clone https://github.com/skrskr/Foodics-Coding-Challenge.git
```
- 2. create `.env` file
```bash
cd Foodics-Coding-Challenge && cp .env.example .env
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
# if you have issues stop containers and up again
# only for first time APP_KEY not exist in .env and not reflected till we restarted the container
make dev_down
make dev
```
- The project will up and running on port `8000` http://localhost:8000
- The mailhog service will be up and running on port `8025` http://localhost:8025

- 5. Seeding data in database
```bash
# Using make 
make seed
# docker command
# docker compose -f local.yml run --rm worker php artisan db:seed
```

- 6. Creating order using `curl` command line
```bash
curl -X POST -H "Content-Type: application/json" -d '{"products":[{"product_id": 1, "quantity": 1}]}' http://localhost:8000/api/v1/orders

# for test sending email when quantity is less than 50% increase quantity to 45
curl -X POST -H "Content-Type: application/json" -d '{"products":[{"product_id": 1, "quantity": 45}]}' http://localhost:8000/api/v1/orders
#then check mailhog interface new email received (http://localhost:8025)

# for test email will send only once try make another order with quantity 1
curl -X POST -H "Content-Type: application/json" -d '{"products":[{"product_id": 1, "quantity": 1}]}' http://localhost:8000/api/v1/orders
# then check mailhog it's only one mail sent until merchant increased the quantity of ingredient
# we will set is_merchant_notified=false and then merchant will receive email again if quantity less than 50%
```

- 7. Running test
```bash
# Using make 
make test
# docker command
# docker compose -f local.yml run --rm worker php artisan test
```