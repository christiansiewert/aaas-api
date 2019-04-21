# API as a Service _API_

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
docker-compose exec php composer install
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

## Continuous Integration

### Running tests

```bash
docker-compose exec php php bin/phpunit
```

### Generate PHP_CodeSniffer XML Report

```bash
docker-compose exec php ./vendor/squizlabs/php_codesniffer/bin/phpcs \
    --report=xml --report-file=./docs/phpcs.xml
```

### Generate Code Coverage HTML Report

```bash
docker-compose exec php php bin/phpunit --coverage-html ./docs/coverage
```

### Generate PHP Mess Detector HTML Report

```bash
docker-compose exec php ./vendor/phpmd/phpmd/src/bin/phpmd src/ html \
    cleancode,codesize,unusedcode,naming --reportfile docs/phpmd.html
```

[Docker and Docker Compose]: https://docs.docker.com/engine/installation
[Swagger UI]: https://swagger.io/tools/swagger-ui/
