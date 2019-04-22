[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Travis Status](https://img.shields.io/travis/siewert87/aaas-api.svg?label=Build)](https://travis-ci.org/siewert87/aaas-api)

# API as a Service - API

This is the **API as a Service** API.

With **API as a Service** you can easily build PHP APIs via a GUI.

# Installation Instructions

## Requirements

* [Docker and Docker Compose]

## Configuration

Application configuration is stored in `.env` file. 

### Application environment
You can change application environment to `dev` of `prod` by changing `APP_ENV` variable in `.env` file.

### DB name and credentials
An `app` database is created by default with user `app` and password `app`. root password is `app`.

## Installation

### 1. Start Containers 

```bash
docker-compose up
```

### 2. Build Backend

Install dependencies

```bash
docker-compose exec php composer install --prefer-dist --optimize-autoloader
```

Generate JWT Certificate

```bash
$ docker-compose exec php openssl genrsa -out config/jwt/private.pem -aes256 4096
$ docker-compose exec php openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

Don't forget to update `JWT_PASSPHRASE` in `.env` file. By default it's `app!`

### 3. Build Database

Update database credentials in `.env` and deploy schema:

```bash
docker-compose exec php bin/console doctrine:migrations:migrate --no-interaction
```

If you want to modify the entities, don't forget to run:

```bash
docker-compose exec php bin/console doctrine:migrations:diff
```

If you want to load the fixtures run:

```bash
docker-compose exec mariadb sh -c "mysql -u app -p app < /app/docs/db_fixtures.sql"
```

# Visit Docs

For [Swagger UI] open https://localhost in your browser.

# Useful commands and shortcuts

## Shortcuts
It is recommended to add short aliases for the following frequently used container commands:

* `docker-compose exec php /bin/bash` to run a shell inside the php container
* `docker-compose exec php php` to run php in container
* `docker-compose exec php bin/console` to run Symfony CLI commands
* `docker-compose exec php bin/console cache:clear` to clear cache
* `docker-compose exec php composer update` to update composer dependencies
* `docker-compose exec mariadb mysql -u app -p app` to run MySQL commands (Password is `app`)

# Continuous Integration

## Running tests

```bash
docker-compose exec php bin/phpunit
```

## Generate PHP CodeSniffer XML Report

```bash
docker-compose exec php ./vendor/bin/phpcs --report=xml --report-file=./docs/phpcs.xml
```

## Generate Code Coverage HTML Report

```bash
docker-compose exec php php bin/phpunit --coverage-html ./docs/coverage
```

## Generate PHP Mess Detector HTML Report

```bash
docker-compose exec php ./vendor/bin/phpmd src/ html phpmd.xml.dist --reportfile ./docs/phpmd.html
```

## Generate PHP Depend Metrics

```bash
docker-compose exec php ./vendor/bin/pdepend --summary-xml=./docs/php-pdepend.xml \
--jdepend-chart=./docs/php-jdepend.svg --overview-pyramid=./docs/php-pyramid.svg \
--ignore=src/Migrations/ ./src
```

[Docker and Docker Compose]: https://docs.docker.com/engine/installation
[Swagger UI]: https://swagger.io/tools/swagger-ui/
